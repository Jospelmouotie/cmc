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
    // Increase cache times for more stable data
    private const CACHE_EVENTS = 600; // 10 minutes
    private const CACHE_PATIENTS = 1800; // 30 minutes
    private const CACHE_MEDECINS = 3600; // 1 hour

    public function index(Request $request)
    {
        $user = auth()->user();
        $userRole = $user->role_id;

        // Check if it's an AJAX/API request for events data
        if ($request->wantsJson() || $request->ajax()) {
            return $this->getEventsJson($user);
        }

        // For regular web requests - only load resources
        $ressources = Cache::remember('medecins_ressources', self::CACHE_MEDECINS, function (){
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

    private function getEventsJson($user)
    {
        $cacheKey = 'events_optimized_' . $user->id . '_' . $user->role_id;

        $events = Cache::remember($cacheKey, self::CACHE_EVENTS, function () use ($user) {
            $query = Event::select([
                'id', 'title', 'start', 'end',
                'user_id', 'patient_id', 'statut',
                'objet', 'description'
            ]);

            // Filter by user role
            if ($user->role_id === 2) {
                $query->where('user_id', $user->id);
            }

            // Use single query with joins instead of eager loading
            return DB::table('events')
                ->select([
                    'events.id',
                    'events.title',
                    'events.start',
                    'events.end',
                    'events.user_id',
                    'events.patient_id',
                    'events.statut',
                    'events.objet',
                    'events.description',
                    'patients.name as patient_name',
                    'patients.prenom as patient_prenom',
                    'users.name as medecin_name',
                    'users.prenom as medecin_prenom'
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

    public function medecinEvents(Request $request, $id_medecin)
    {
        $user = auth()->user();

        if ($user->role_id === 2 && $user->id != $id_medecin) {
            abort(403, 'Vous ne pouvez voir que vos propres rendez-vous.');
        }

        // Check if it's an AJAX/API request
        if ($request->wantsJson() || $request->ajax()) {
            return $this->getMedecinEventsJson($id_medecin);
        }

        // For regular web requests
        $medecin = User::select(['id', 'name', 'prenom'])
            ->findOrFail($id_medecin);

        return view('admin.events.show', [
            'medecin' => $medecin,
            'medecinId' => $id_medecin,
        ]);
    }

    private function getMedecinEventsJson($id_medecin)
    {
        $cacheKey = "medecin_{$id_medecin}_events_optimized";

        $events = Cache::remember($cacheKey, self::CACHE_EVENTS, function () use ($id_medecin) {
            return DB::table('events')
                ->select([
                    'events.id',
                    'events.title',
                    'events.start',
                    'events.end',
                    'events.user_id',
                    'events.patient_id',
                    'events.statut',
                    'events.objet',
                    'events.description',
                    'patients.name as patient_name',
                    'patients.prenom as patient_prenom',
                    'users.name as medecin_name',
                    'users.prenom as medecin_prenom'
                ])
                ->leftJoin('patients', 'events.patient_id', '=', 'patients.id')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->where('events.user_id', $id_medecin)
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
            'start' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string',
            'statut' => 'nullable|string',
        ]);

        $statut = $validated['statut'] ?? 'a venir';

        if (auth()->user()->role_id === 2 && $statut !== 'a venir') {
            return response()->json([
                'success' => false,
                'message' => 'Les médecins ne peuvent créer que des rendez-vous "à venir"'
            ], 403);
        }

        // Parse start date and set time to beginning of day
        $startDate = Carbon::parse($validated['start'])->startOfDay();
        // Set end to the same day at 23:59:59
        $endDate = Carbon::parse($validated['start'])->endOfDay();

        $event = Event::create([
            'patient_id' => $validated['patient_id'],
            'user_id' => $validated['medecin_id'],
            'title' => $validated['title'],
            'objet' => $validated['objet'],
            'start' => $startDate,
            'end' => $endDate,
            'description' => $validated['description'] ?? '',
            'statut' => $statut,
            'state' => 'aucun'
        ]);

        // Clear relevant caches with optimized keys
        $this->clearEventCaches($validated['medecin_id']);

        // Load relationships efficiently
        $event->load(['patients:id,name,prenom', 'user:id,name,prenom']);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous créé avec succès',
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'patient_id' => $event->patient_id,
                'medecin_id' => $event->user_id,
                'description' => $event->description,
                'objet' => $event->objet,
                'statut' => $event->statut,
                'color' => $this->getColorByStatut($event->statut),
                'patient' => $event->patients ? [
                    'id' => $event->patients->id,
                    'name' => $event->patients->name,
                    'prenom' => $event->patients->prenom
                ] : null,
                'medecin' => $event->user ? [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                    'prenom' => $event->user->prenom
                ] : null,
            ]
        ], 201);
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
            'description' => 'nullable|string',
            'statut' => 'nullable|string',
            'new_report_date' => 'nullable|date|after_or_equal:today',
        ]);

        // Validate status changes for medecins
        if (auth()->user()->role_id === 2 && isset($validated['statut'])) {
            $allowedStatuses = ['a venir', 'vu', 'reporté'];
            if (!in_array($validated['statut'], $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Les médecins ne peuvent changer le statut qu\'à "à venir", "vu" ou "reporté"'
                ], 403);
            }
        }

        // Handle "reporté" status - create new event at new date
        if (isset($validated['statut']) && $validated['statut'] === 'reporté') {
            if (!isset($validated['new_report_date'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'La nouvelle date est requise pour reporter un rendez-vous'
                ], 422);
            }

            // Create new event at the new date
            $newStart = Carbon::parse($validated['new_report_date'])->startOfDay();
            $newEnd = Carbon::parse($validated['new_report_date'])->endOfDay();

            $newEvent = Event::create([
                'patient_id' => $event->patient_id,
                'user_id' => $event->user_id,
                'title' => $event->title,
                'objet' => $event->objet,
                'start' => $newStart,
                'end' => $newEnd,
                'description' => $event->description . "\n[Reporté depuis le " . Carbon::parse($event->start)->format('d/m/Y') . "]",
                'statut' => 'a venir',
                'state' => 'aucun'
            ]);

            // Update original event to "reporté" status
            $event->update([
                'statut' => 'reporté'
            ]);

            // Clear caches
            $this->clearEventCaches($event->user_id);

            // Load relationships for both events
            $event->load(['patients:id,name,prenom', 'user:id,name,prenom']);
            $newEvent->load(['patients:id,name,prenom', 'user:id,name,prenom']);

            return response()->json([
                'success' => true,
                'message' => 'Rendez-vous reporté avec succès. Un nouveau rendez-vous a été créé pour le ' . $newStart->format('d/m/Y'),
                'event' => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'patient_id' => $event->patient_id,
                    'medecin_id' => $event->user_id,
                    'description' => $event->description,
                    'objet' => $event->objet,
                    'statut' => $event->statut,
                    'color' => $this->getColorByStatut($event->statut),
                    'patient' => $event->patients ? [
                        'id' => $event->patients->id,
                        'name' => $event->patients->name,
                        'prenom' => $event->patients->prenom
                    ] : null,
                    'medecin' => $event->user ? [
                        'id' => $event->user->id,
                        'name' => $event->user->name,
                        'prenom' => $event->user->prenom
                    ] : null,
                ],
                'newEvent' => [
                    'id' => $newEvent->id,
                    'title' => $newEvent->title,
                    'start' => $newEvent->start,
                    'end' => $newEvent->end,
                    'patient_id' => $newEvent->patient_id,
                    'medecin_id' => $newEvent->user_id,
                    'description' => $newEvent->description,
                    'objet' => $newEvent->objet,
                    'statut' => $newEvent->statut,
                    'color' => $this->getColorByStatut($newEvent->statut),
                    'patient' => $newEvent->patients ? [
                        'id' => $newEvent->patients->id,
                        'name' => $newEvent->patients->name,
                        'prenom' => $newEvent->patients->prenom
                    ] : null,
                    'medecin' => $newEvent->user ? [
                        'id' => $newEvent->user->id,
                        'name' => $newEvent->user->name,
                        'prenom' => $newEvent->user->prenom
                    ] : null,
                ]
            ]);
        }

        // Regular update for non-reporté status
        if (isset($validated['start'])) {
            $validated['start'] = Carbon::parse($validated['start'])->startOfDay();
            $validated['end'] = Carbon::parse($validated['start'])->endOfDay();
        }

        $oldMedecinId = $event->user_id;
        if (isset($validated['medecin_id'])) {
            $validated['user_id'] = $validated['medecin_id'];
            unset($validated['medecin_id']);
        }

        $event->update($validated);

        // Clear caches
        $this->clearEventCaches($event->user_id);
        if (isset($validated['user_id']) && $validated['user_id'] != $oldMedecinId) {
            $this->clearEventCaches($oldMedecinId);
        }

        $event->load(['patients:id,name,prenom', 'user:id,name,prenom']);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous modifié avec succès',
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'patient_id' => $event->patient_id,
                'medecin_id' => $event->user_id,
                'description' => $event->description,
                'objet' => $event->objet,
                'statut' => $event->statut,
                'color' => $this->getColorByStatut($event->statut),
                'patient' => $event->patients ? [
                    'id' => $event->patients->id,
                    'name' => $event->patients->name,
                    'prenom' => $event->patients->prenom
                ] : null,
                'medecin' => $event->user ? [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                    'prenom' => $event->user->prenom
                ] : null,
            ]
        ]);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $medecin_id = $event->user_id;
        $event->delete();

        // Clear caches
        $this->clearEventCaches($medecin_id);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous supprimé avec succès'
        ]);
    }

    // OPTIMIZED: Paginated patient search with minimal data
    public function getPatients(Request $request)
    {
        $q = trim($request->query('q', ''));
        $page = $request->query('page', 1);
        $perPage = 50;

        // If searching, don't cache
        if ($q !== '') {
            $patients = Patient::select(['id', 'name', 'prenom'])
                ->where(function($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('prenom', 'like', "%{$q}%")
                        ->orWhere('numero_dossier', 'like', "%{$q}%");
                })
                ->latest()
                ->limit($perPage)
                ->get();

            return response()->json($patients);
        }

        // Cache full list with longer TTL
        $cacheKey = "patients_dropdown_page_{$page}";
        $patients = Cache::remember($cacheKey, self::CACHE_PATIENTS, function () use ($perPage, $page) {
            return Patient::select(['id', 'name', 'prenom'])
                ->latest()
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();
        });

        return response()->json($patients);
    }

    public function getMedecins(Request $request)
    {
        $user = auth()->user();
        $q = trim($request->query('q', ''));

        // Build cache key based on user role
        $cacheKey = "medecins_dropdown_" . $user->role_id . "_" . $user->id;
        if ($q) {
            $cacheKey .= "_" . md5($q);
        }

        $medecins = Cache::tags(['medecins'])->remember($cacheKey, self::CACHE_MEDECINS, function () use ($q, $user) {
            $query = User::where('role_id', 2)
                ->select('id', 'name', 'prenom')
                ->orderBy('name');

            // If user is a medecin, only return themselves
            if ($user->role_id === 2) {
                $query->where('id', $user->id);
            }

            if ($q !== '') {
                $query->where(function($qb) use ($q) {
                    $qb->where('name', 'like', "%{$q}%")
                       ->orWhere('prenom', 'like', "%{$q}%");
                });
            }

            return $query->get();
        });

        return response()->json($medecins);
    }

    public function allMedecinsEvents(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role_id, [1, 6])) {
            abort(403, 'Accès non autorisé');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return $this->getEventsJson($user);
        }
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

    // Helper method to clear all event-related caches
    private function clearEventCaches($medecinId = null)
    {
        // Clear user-specific caches
        $users = User::select(['id', 'role_id'])->get();
        foreach ($users as $user) {
            Cache::forget('events_optimized_' . $user->id . '_' . $user->role_id);
        }

        // Clear medecin-specific cache
        if ($medecinId) {
            Cache::forget("medecin_{$medecinId}_events_optimized");
        }

        // Clear old cache keys for backward compatibility
        Cache::forget('events_with_patients');
        if ($medecinId) {
            Cache::forget("medecin_{$medecinId}_events");
        }
    }

    public function clearMedecinCaches()
    {
        Cache::tags(['medecins'])->flush();
    }
}
