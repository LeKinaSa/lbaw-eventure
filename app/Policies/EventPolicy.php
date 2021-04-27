<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventPolicy {
    use HandlesAuthorization;

    public function show(User $user, Event $event) {
        if ($event->visibility == 'Public') {
            // Public event can be seen by everyone
            return true;
        }
        if ($user->id == $event->id_organizer) {
            // Organizer can see the event
            return true;
        }
        // TODO: private events can be seen by administrators and participants
        return true;
    }
    public function list(User $user) {
        // Any user can list its own events
        return Auth::check();
    }
    
    public function create(User $user) {
        // Any user can create a new event
        return Auth::check();
    }

    public function delete(User $user, Event $event) {
        // Only a event organizer can delete it
        return $user->id == $event->id_organizer;
    }
}
