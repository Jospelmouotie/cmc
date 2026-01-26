<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    // Délais de cache en secondes
    private const CACHE_EVENTS = 600;    // 10 minutes
    private const CACHE_PATIENTS = 1800;  // 30 minutes
    private const CACHE_MEDECINS = 3600;  // 1 heure

    public function index(Request $request)
    {
        $user = auth()->user();
        $userRole = $user->role_id;

        // Si c'est une requête AJAX (FullCalendar), on renvoie le JSON
        if ($request->wantsJson() || $request->ajax()) {
            return $this->getEventsJson($user);
        }

        // Chargement des médecins sans utiliser les tags (Fix Render)
        $ressources = Cache::remember('medecins_ressources_list', self::CACHE_MEDECINS, function (){
            return User::where('role_id', 2)
                ->select('id', 'name', 'prenom')
                ->orderBy('name')
                ->get();
        });

        // Permissions
        $canCreate = $user->can('create', Event::class);
        $canUpdate = $user->can('update', Event::class);
        $canDelete = $user->can('delete', Event::class);

        return view('admin.events.index', compact('ressources', 'canCreate', 'canUpdate', 'canDelete', 'userRole'));
    }


    public function medecinEvents(Request $request, $id_medecin)
    {
        $user = auth()->user();

        // Sécurité : Un médecin ne peut voir que ses propres événements
        if ($user->role_id === 2 && $user->id != $id_medecin) {
            abort(403, 'Vous ne pouvez voir que vos propres rendez-vous.');
        }

        // Si c'est une requête AJAX (FullCalendar)
        if ($request->wantsJson() || $request->ajax()) {
            return $this->getMedecinEventsJson($id_medecin);
        }

        // Pour l'affichage de la vue classique
        $medecin = User::select(['id', 'name', 'prenom'])->findOrFail($id_medecin);

        return view('admin.events.show', [
            'medecin' => $medecin,
            'medecinId' => $id_medecin,
        ]);
    }

    private function getMedecinEventsJson($id_medecin)
    {
        $cacheKey = "medecin_events_list_json_" . $id_medecin;

        $events = Cache::remember($cacheKey, self::CACHE_EVENTS, function () use ($id_medecin) {
            return DB::table('events')
                ->select([
                    'events.id', 'events.title', 'events.start', 'events.end',
                    'events.user_id', 'events.patient_id', 'events.statut',
                    'events.objet', 'events.description',
                    'patients.name as patient_name', 'patients.prenom as patient_prenom'
                ])
                ->leftJoin('patients', 'events.patient_id', '=', 'patients.id')
                ->where('events.user_id', $id_medecin)
                ->get()
                ->map(function($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'start' => $event->start,
                        'end' => $event->end,
                        'statut' => $event->statut ?? 'a venir',
                        'color' => $this->getColorByStatut($event->statut ?? 'a venir'),
                        'patient' => [
                            'name' => $event->patient_name,
                            'prenom' => $event->patient_prenom
                        ]
                    ];
                });
        });

        return response()->json($events);
    }
    private function getEventsJson($user)
    {
        // Clé de cache unique par utilisateur et rôle
        $cacheKey = 'events_optimized_user_' . $user->id;

        $events = Cache::remember($cacheKey, self::CACHE_EVENTS, function () use ($user) {
            return DB::table('events')
                ->select([
                    'events.id', 'events.title', 'events.start', 'events.end',
                    'events.user_id', 'events.patient_id', 'events.statut',
                    'events.objet', 'events.description',
                    'patients.name as patient_name', 'patients.prenom as patient_prenom',
                    'users.name as medecin_name', 'users.prenom as medecin_prenom'
                ])
                ->leftJoin('patients', 'events.patient_id', '=', 'patients.id')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->when($user->role_id === 2, function ($q) use ($user) {
                    return $q->where('events.user_id', $user->id);
                })
                ->get()
                ->map(function($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'start' => $event->start,
                        'end' => $event->end,
                        'patient_id' => $event->patient_id,
                        'medecin_id' => $event->user_id,
                        'description' => $event->description ?? '',
                        'objet' => $event->objet ?? '',
                        'statut' => $event->statut ?? 'a venir',
                        'color' => $this->getColorByStatut($event->statut ?? 'a venir'),
                        'patient' => $event->patient_id ? [
                            'id' => $event->patient_id,
                            'name' => $event->patient_name,
                            'prenom' => $event->patient_prenom
                        ] : null,
                        'medecin' => $event->user_id ? [
                            'id' => $event->user_id,
                            'name' => $event->medecin_name,
                            'prenom' => $event->medecin_prenom
                        ] : null,
                    ];
                });
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'objet' => 'required|string',
            'start' => 'required|date',
            'description' => 'nullable|string',
            'statut' => 'nullable|string',
        ]);

        $event = Event::create([
            'patient_id' => $validated['patient_id'],
            'user_id' => $validated['medecin_id'],
            'title' => $validated['title'],
            'objet' => $validated['objet'],
            'start' => Carbon::parse($validated['start'])->startOfDay(),
            'end' => Carbon::parse($validated['start'])->endOfDay(),
            'description' => $validated['description'] ?? '',
            'statut' => $validated['statut'] ?? 'a venir',
            'state' => 'aucun'
        ]);

        $this->clearAllEventCaches();

        return response()->json(['success' => true, 'event' => $event], 201);
    }

    public function updateSingle(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id',
            'medecin_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'objet' => 'sometimes|string',
            'start' => 'sometimes|date',
            'statut' => 'nullable|string',
        ]);

        if (isset($validated['medecin_id'])) {
            $validated['user_id'] = $validated['medecin_id'];
        }

        $event->update($validated);

        $this->clearAllEventCaches();

        return response()->json(['success' => true]);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();

        $this->clearAllEventCaches();

        return response()->json(['success' => true]);
    }

    public function getPatients(Request $request)
    {
        $q = trim($request->query('q', ''));

        // Pas de cache pour les recherches actives
        if ($q !== '') {
            return response()->json(Patient::select(['id', 'name', 'prenom'])
                ->where('name', 'like', "%{$q}%")
                ->orWhere('prenom', 'like', "%{$q}%")
                ->limit(20)->get());
        }

        return response()->json(Cache::remember('patients_list_simple', self::CACHE_PATIENTS, function () {
            return Patient::select(['id', 'name', 'prenom'])->latest()->limit(50)->get();
        }));
    }

    public function getMedecins(Request $request)
    {
        $user = auth()->user();
        $cacheKey = "medecins_dropdown_list_" . $user->id;

        return response()->json(Cache::remember($cacheKey, self::CACHE_MEDECINS, function () use ($user) {
            $query = User::where('role_id', 2)->select('id', 'name', 'prenom');
            if ($user->role_id === 2) $query->where('id', $user->id);
            return $query->get();
        }));
    }

    private function getColorByStatut($statut)
    {
        $colors = [
            'a venir' => '#4682B4',
            'vu' => '#008B8B',
            'absence excusé' => '#DDA0DD',
            'absence non excusé' => '#6A5ACD',
            'reporté' => '#FF6347',
        ];
        return $colors[$statut] ?? '#3788d8';
    }

    // Méthode de nettoyage sécurisée pour driver "FILE"
    private function clearAllEventCaches()
    {
        // Sur Render Free, vider tout le cache est la méthode la plus fiable
        // pour que les changements (ajout/suppression RDV) soient visibles partout immédiatement.
        Cache::flush();
    }
}
