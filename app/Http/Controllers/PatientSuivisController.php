<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationAnesthesiste;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PatientSuivisController extends Controller
{
    /**
     * Obtenir le nombre de patients uniques suivis par le médecin actuel
     */
    public function getPatientsSuivisCount($userId = null)
    {
        $userId = $userId ?? Auth::id();
        $cacheKey = "patients_suivis_count_{$userId}";

        // CORRECTION : Suppression de tags()
        return Cache::remember($cacheKey, 600, function () use ($userId) {
            $patientIds = DB::table('consultations')
                ->select('patient_id')
                ->where('user_id', $userId)
                ->union(
                    DB::table('consultation_anesthesistes')
                        ->select('patient_id')
                        ->where('user_id', $userId)
                )
                ->distinct()
                ->pluck('patient_id');

            return $patientIds->count();
        });
    }

    /**
     * Liste paginée des patients suivis
     */
    public function patientsSuivis(Request $request)
    {
        $userId = Auth::id();
        $perPage = (int) $request->input('per_page', 25);
        $page = (int) $request->input('page', 1);
        $search = $request->input('search');

        $cacheKey = sprintf(
            'patients_suivis_%s_%s_%s_%s',
            $userId, $page, $perPage, md5($search ?? '')
        );

        // CORRECTION : Suppression de tags()
        $data = Cache::remember($cacheKey, 300, function () use ($userId, $perPage, $search) {
            $patientIdsSubquery = DB::table('consultations')
                ->select('patient_id')
                ->where('user_id', $userId)
                ->union(
                    DB::table('consultation_anesthesistes')
                        ->select('patient_id')
                        ->where('user_id', $userId)
                )
                ->distinct();

            $query = Patient::select([
                    'patients.id',
                    'patients.numero_dossier',
                    'patients.name',
                    'patients.prenom',
                    'patients.created_at'
                ])
                ->whereIn('patients.id', $patientIdsSubquery)
                ->with([
                    'consultations' => function($query) use ($userId) {
                        $query->select('id', 'patient_id', 'user_id', 'created_at')
                            ->where('user_id', $userId)
                            ->latest()
                            ->limit(1);
                    },
                    'consultation_anesthesistes' => function($query) use ($userId) {
                        $query->select('id', 'patient_id', 'user_id', 'created_at')
                            ->where('user_id', $userId)
                            ->latest()
                            ->limit(1);
                    }
                ]);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('numero_dossier', 'like', "%{$search}%");
                });
            }

            return $query->latest('patients.created_at')->paginate($perPage);
        });

        if ($search) {
            $data->appends(['search' => $search]);
        }

        $stats = $this->getPatientsSuivisStatistics($userId);

        return view('admin.patients_suivis.index', [
            'patients' => $data,
            'search' => $search,
            'perPage' => $perPage,
            'stats' => $stats,
        ]);
    }

    /**
     * Statistiques pour la page des patients suivis
     */
    private function getPatientsSuivisStatistics($userId)
    {
        $cacheKey = "patients_suivis_stats_{$userId}";

        // CORRECTION : Suppression de tags()
        return Cache::remember($cacheKey, 600, function () use ($userId) {
            $consultationsCount = DB::table('consultations')
                ->where('user_id', $userId)
                ->distinct('patient_id')
                ->count('patient_id');

            $anesthesisteCount = DB::table('consultation_anesthesistes')
                ->where('user_id', $userId)
                ->distinct('patient_id')
                ->count('patient_id');

            $totalPatients = $this->getPatientsSuivisCount($userId);

            return [
                'total_patients' => $totalPatients,
                'consultations_chirurgien' => $consultationsCount,
                'consultations_anesthesiste' => $anesthesisteCount,
            ];
        });
    }

    /**
     * Vider le cache des patients suivis
     */
    public static function clearPatientsSuivisCache($userId = null)
    {
        // CORRECTION : Utilisation de flush() global ou suppression de clés spécifiques
        // car le driver 'file' ne permet pas de vider par tag sélectivement
        Cache::flush();
    }

    /**
     * Activité récente pour le dashboard
     */
    public function recentActivity(Request $request)
    {
        $userId = Auth::id();
        $limit = (int) $request->input('limit', 10);
        $cacheKey = "recent_activity_{$userId}_{$limit}";

        // CORRECTION : Suppression de tags()
        $activity = Cache::remember($cacheKey, 300, function () use ($userId, $limit) {
            $consultations = Consultation::select([
                    'id', 'patient_id', 'user_id', 'created_at',
                    DB::raw("'chirurgien' as type")
                ])
                ->where('user_id', $userId)
                ->with('patient:id,name,prenom,numero_dossier');

            $anesthesiste = ConsultationAnesthesiste::select([
                    'id', 'patient_id', 'user_id', 'created_at',
                    DB::raw("'anesthesiste' as type")
                ])
                ->where('user_id', $userId)
                ->with('patient:id,name,prenom,numero_dossier');

            return $consultations
                ->union($anesthesiste)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });

        return response()->json($activity);
    }

    public function export(Request $request)
    {
        $this->authorize('update', Patient::class);
        $userId = Auth::id();

        $patientIds = DB::table('consultations')
            ->select('patient_id')
            ->where('user_id', $userId)
            ->union(
                DB::table('consultation_anesthesistes')
                    ->select('patient_id')
                    ->where('user_id', $userId)
            )
            ->distinct()
            ->pluck('patient_id');

        $patients = Patient::select(['numero_dossier', 'name', 'prenom', 'created_at'])
            ->whereIn('id', $patientIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $patients->count(),
            'message' => 'Export ready'
        ]);
    }
}
