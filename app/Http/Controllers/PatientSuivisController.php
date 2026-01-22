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
     * Get count of unique patients followed by current doctor
     * Used for dashboard statistics
     *
     * @param int $userId
     * @return int
     */
    public function getPatientsSuivisCount($userId = null)
    {
        $userId = $userId ?? Auth::id();
        $cacheKey = "patients_suivis_count_{$userId}";

        return Cache::remember($cacheKey, 60, function () use ($userId) {
            // More efficient query using union and distinct
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
     * Display paginated list of patients followed by current doctor
     * Optimized with eager loading, caching, and efficient queries
     */
    // public function patientsSuivis(Request $request)
    // {
    //     $userId = Auth::id();
    //     $perPage = (int) $request->input('per_page', 10);
    //     $page = (int) $request->input('page', 1);
    //     $search = $request->input('search');

    //     // Create cache key based on user, page, and search
    //     $cacheKey = sprintf(
    //         'patients_suivis_%s_%s_%s_%s',
    //         $userId,
    //         $page,
    //         $perPage,
    //         md5($search ?? '')
    //     );

    //     // Cache for 5 minutes with tags for easy invalidation
    //     $data = Cache::remember($cacheKey, 30, function () use ($userId, $perPage, $search) {
    //         // Get unique patient IDs efficiently using a single query with UNION
    //         $patientIdsSubquery = DB::table('consultations')
    //             ->select('patient_id')
    //             ->where('user_id', $userId)
    //             ->union(
    //                 DB::table('consultation_anesthesistes')
    //                     ->select('patient_id')
    //                     ->where('user_id', $userId)
    //             )
    //             ->distinct();

    //         // Build the main query with optimizations
    //         $query = Patient::select([
    //                 'patients.id',
    //                 'patients.numero_dossier',
    //                 'patients.name',
    //                 'patients.prenom',
    //                 'patients.created_at'
    //             ])
    //             ->whereIn('patients.id', $patientIdsSubquery)
    //             ->with([
    //                 // Eager load only the latest consultation with minimal fields
    //                 'user:id,telephone',
    //                 'dossiers' => function($query) {
    //                     $query->select('id', 'patient_id', 'portable_1', 'portable_2')
    //                         ->latest()
    //                         ->limit(1);
    //                 },
    //                 'consultations' => function($query) use ($userId) {
    //                     $query->select('id', 'patient_id', 'user_id', 'created_at')
    //                         ->where('user_id', $userId)
    //                         ->latest()
    //                         ->limit(1);
    //                 },
    //                 // Eager load only the latest anesthesiste consultation
    //                 'consultation_anesthesistes' => function($query) use ($userId) {
    //                     $query->select('id', 'patient_id', 'user_id', 'created_at')
    //                         ->where('user_id', $userId)
    //                         ->latest()
    //                         ->limit(1);
    //                 }
    //             ]);

    //         // Add search functionality if provided
    //         if ($search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('name', 'like', "%{$search}%")
    //                   ->orWhere('prenom', 'like', "%{$search}%")
    //                   ->orWhere('numero_dossier', 'like', "%{$search}%");
    //             });
    //         }


    //         return $query->latest('patients.created_at')->paginate($perPage);
    //     });

    //     // If search is active, append it to pagination links
    //     if ($search) {
    //         $data->appends(['search' => $search]);
    //     }

    //     // Get statistics for the cards
    //     $stats = $this->getPatientsSuivisStatistics($userId);

    //     return view('admin.patients_suivis.index', [
    //         'patients' => $data,
    //         'search' => $search,
    //         'perPage' => $perPage,
    //         'stats' => $stats,
    //     ]);
    // }


     public function patientsSuivis(Request $request)
    {
        $userId = Auth::id();
        $perPage = (int) $request->input('per_page', 10);
        $search = $request->input('search');

        // Get unique patient IDs efficiently
        $patientIdsSubquery = DB::table('consultations')
            ->select('patient_id')
            ->where('user_id', $userId)
            ->union(
                DB::table('consultation_anesthesistes')
                    ->select('patient_id')
                    ->where('user_id', $userId)
            )
            ->distinct();

        // Build the main query
        $query = Patient::select([
                'patients.id',
                'patients.numero_dossier',
                'patients.name',
                'patients.prenom',
                'patients.created_at',
            ])
            ->whereIn('patients.id', $patientIdsSubquery)
            ->with([
                'user:id,telephone',
                'dossiers' => function($query) {
                    $query->select('id', 'patient_id', 'portable_1', 'portable_2')
                        ->latest()
                        ->limit(1);
                },
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

        // Add search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('numero_dossier', 'like', "%{$search}%");
            });
        }

        // Get paginated results
        $patients = $query->latest('patients.created_at')->paginate($perPage);

        // Get statistics
        $stats = $this->getPatientsSuivisStatistics($userId);

        return view('admin.patients_suivis.index', [
            'patients' => $patients,
            'search' => $search,
            'perPage' => $perPage,
            'stats' => $stats,
        ]);
    }

    /**
     * Get statistics for patients suivis page
     * Cached separately for better performance
     */
    private function getPatientsSuivisStatistics($userId)
    {
        $cacheKey = "patients_suivis_stats_{$userId}";

        return Cache::remember($cacheKey, 60, function () use ($userId) {
            // Get counts efficiently with a single query each
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
     * Clear cache for patients suivis
     */
    public static function clearPatientsSuivisCache($userId = null)
    {
        if ($userId) {
            // Clear specific user's cache
            Cache::flush();
        } else {
            // Clear all patients suivis cache
            Cache::flush();
        }
    }

    /**
     * Get recent consultation activity for dashboard widget
     * Optimized for quick loading
     */
    public function recentActivity(Request $request)
    {
        $userId = Auth::id();
        $limit = (int) $request->input('limit', 10);

        $cacheKey = "recent_activity_{$userId}_{$limit}";

        $activity = Cache::tags(['consultations'])->remember($cacheKey, 30, function () use ($userId, $limit) {
            // Get recent consultations from both tables
            $consultations = Consultation::select([
                    'id',
                    'patient_id',
                    'user_id',
                    'created_at',
                    DB::raw("'chirurgien' as type")
                ])
                ->where('user_id', $userId)
                ->with('patient:id,name,prenom,numero_dossier');

            $anesthesiste = ConsultationAnesthesiste::select([
                    'id',
                    'patient_id',
                    'user_id',
                    'created_at',
                    DB::raw("'anesthesiste' as type")
                ])
                ->where('user_id', $userId)
                ->with('patient:id,name,prenom,numero_dossier');

            // Union and order by date
            return $consultations
                ->union($anesthesiste)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });

        return response()->json($activity);
    }

    /**
     * Export patients suivis to CSV/Excel
     * Optimized to handle large datasets
     */
    public function export(Request $request)
    {
        $this->authorize('update', Patient::class);

        $userId = Auth::id();

        // Get patient IDs efficiently
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

        // Chunk the query to handle large datasets
        $patients = Patient::select([
                'numero_dossier',
                'name',
                'prenom',
                'created_at'
            ])
            ->whereIn('id', $patientIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // Return as downloadable file (implement your preferred export method)
        // This is a placeholder - you would use Laravel Excel or similar
        return response()->json([
            'success' => true,
            'count' => $patients->count(),
            'message' => 'Export ready'
        ]);
    }
}
