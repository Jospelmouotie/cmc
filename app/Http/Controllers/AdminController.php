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
        
        // Cache dashboard statistics for 5 minutes
        $stats = Cache::remember("dashboard_stats_{$userId}", 300, function () use ($userId) {
            return [
                'produits' => Produit::count(),
                'users' => User::count(),
                'patients' => Patient::count(),
                'events' => Event::where('user_id', $userId)->count(),
                'chambres' => Chambre::count(),
                'fiches' => Fiche::count(),
                // Get the count of patients suivis using the controller method
                'patients_suivis' => app(PatientSuivisController::class)->getPatientsSuivisCount($userId),
            ];
        });
        
        // Optimize consultation query with eager loading and limit
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
     * Activate license key
     */
    public function ActiveLicence(LicenceActiveRequest $request)
    {
        $licence = Licence::where('client', 'cmcuapp')->first();

        $licence->update([
            'license_key' => $request->input('license_key'),
            'expire_date' => Carbon::parse('+1 month')
        ]);
        
        // Clear license cache
        Cache::forget('license_cmcuapp');

        // Flash::info('Votre licence a bien été activée');
        // return back();
        return redirect()
        ->back()
        ->with('info', 'Votre licence a bien été activée');

    }

    /**
     * Redirect to dashboard
     */
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Clear dashboard cache for a specific user
     * Call this after major data changes
     * 
     * @param int|null $userId
     */
    public static function clearDashboardCache($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        Cache::forget("dashboard_stats_{$userId}");
        Cache::forget("dashboard_consultations_{$userId}");
        
        // Also clear patients suivis count cache
        Cache::tags(['patients', 'consultations'])->forget("patients_suivis_count_{$userId}");
    }
}