<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     * Admins have full access to everything.
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the user can view events.
     * Everyone authenticated can view events.
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine if the user can create events.
     * Roles 1, 6 (admins/assistants) and 2 (medecins) can create events.
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1, 2, 6]);
    }

    /**
     * Determine if the user can update events.
     * - Roles 1, 6: Can update any event
     * - Role 2 (medecin): Can only update their own events
     */
    public function update(User $user, Event $event = null)
    {
        // For general permission check (when $event is null)
        if (!$event) {
            return in_array($user->role_id, [1, 2, 6]);
        }
        
        // For specific event update
        // Roles 1 and 6 can update any event
        if (in_array($user->role_id, [1, 6])) {
            return true;
        }
        
        // Role 2 (medecin) can only update their own events
        if ($user->role_id === 2) {
            return $user->id === $event->user_id;
        }
        
        return false;
    }

    /**
     * Determine if the user can delete events.
     * - Roles 1, 6: Can delete any event
     * - Role 2 (medecin): Can only delete their own events
     */
    public function delete(User $user, Event $event = null)
    {
        // For general permission check (when $event is null)
        if (!$event) {
            return in_array($user->role_id, [1, 2, 6]);
        }
        
        // For specific event deletion
        // Roles 1 and 6 can delete any event
        if (in_array($user->role_id, [1, 6])) {
            return true;
        }
        
        // Role 2 (medecin) can only delete their own events
        if ($user->role_id === 2) {
            return $user->id === $event->user_id;
        }
        
        return false;
    }

    /**
     * Determine if the user can restore events.
     */
    public function restore(User $user, Event $event)
    {
        return in_array($user->role_id, [1, 6]);
    }

    /**
     * Determine if the user can permanently delete events.
     */
    public function forceDelete(User $user, Event $event)
    {
        return in_array($user->role_id, [1, 6]);
    }
}