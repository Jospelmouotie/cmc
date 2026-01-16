<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Consultation;
use App\Models\Event;
use App\Http\Requests\LicenceActiveRequest;
use App\Models\Fiche;
use App\Models\Licence;
use App\Models\Patient;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        // Cache des statistiques pour 5 minutes
        $stats = Cache::remember("dashboard_stats_{$userId}", 300, function () use ($userId) {
            return [
                'produits' => Produit::count(),
                'users' => User::count(),
                'patients' => Patient::count(),
                'events' => Event::where('user_id', $userId)->count(),
                'chambres' => Chambre::count(),
                'fiches' => Fiche::count(),
                'patients_suivis' => app(PatientSuivisController::class)->getPatientsSuivisCount($userId),
            ];
        });

        $consultation = Cache::remember("dashboard_consultations_{$userId}", 300, function () use ($userId) {
            return Consultation::with(['user:id,name', 'patient:id,name,prenom'])
                ->where('user_id', $userId)
                ->select('id', 'user_id', 'patient_id', 'date_consultation', 'created_at')
                ->latest()
                ->limit(10)
                ->get();
        });

        return view('admin.dashboard', array_merge($stats, compact('consultation')));
    }

    /**
     * Activer la licence
     */
    public function ActiveLicence(LicenceActiveRequest $request)
    {
        $licence = Licence::where('client', 'cmcuapp')->first();

        $licence->update([
            'license_key' => $request->input('license_key'),
            'expire_date' => Carbon::parse('+1 month')
        ]);

        Cache::forget('license_cmcuapp');

        return redirect()
            ->back()
            ->with('info', 'Votre licence a bien été activée');
    }

    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Vider le cache du dashboard pour un utilisateur spécifique
     */
    public static function clearDashboardCache($userId = null)
    {
        $userId = $userId ?? auth()->id();

        // Suppression simple sans utiliser Cache::tags()
        Cache::forget("dashboard_stats_{$userId}");
        Cache::forget("dashboard_consultations_{$userId}");

        // CORRECTION ICI : Suppression directe de la clé car le driver 'file' ne supporte pas les tags
        Cache::forget("patients_suivis_count_{$userId}");
    }
}
