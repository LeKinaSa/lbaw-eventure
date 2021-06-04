<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use DB;

class EventPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function view(?Authenticatable $user, Event $event) {
        if ($event->visibility === 'Public') {
            // Public events can be seen by everyone
            return true;
        }

        if (!is_null($user) && $user instanceof Administrator) {
            // All events can be seen by administrators
            return true;
        }

        if (optional($user)->id === $event->id_organizer) {
            // Organizer can see their own events
            return true;
        }

        if ($event->participants()->wherePivot('id_user', optional($user)->id)->first() !== null) {
            // Users can see private events they are participating in
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user) {
        // Any user can create a new event
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function update(User $user, Event $event) {
        // Only organizers can update the details of their events
        return $user->id === $event->id_organizer;
    }

    /**
     * Determine whether the user can update the specified event's participations.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function updateParticipation(?User $user, Event $event) {
        // Only the event organizer can update the event's participants
        // Creating and deleting invitations, and updating join requests
        if (is_null($user)) {
            return false;
        }
        return $user->id === $event->id_organizer;
    }

    /**
     * Determine whether the user can update an invitation.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $invitedUser
     * @return mixed
     */
    public static function updateInvitation(User $user, User $invitedUser) {
        // Only the invited user can update his own invitation
        return $user->id === $invitedUser->id;
    }
    
    /**
     * Determine whether the user can request to join the specified event.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function requestToJoin(?User $user, Event $event) {
        if (is_null($user)) {
            return false;
        }

        if ($event->visibility === 'Private') {
            return false;
        }

        if ($event->cancelled) {
            return false;
        }

        if ($user->id === $event->id_organizer) {
            return false;
        }

        return true;
    }

    /**
     * Determines whether the user can cancel the specified event.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function cancel(?User $user, Event $event) {
        // Only the event organizer can cancel the event
        if (is_null($user)) {
            return false;
        }
        return $user->id === $event->id_organizer;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public static function delete(Authenticatable $user, Event $event) {
        // Organizers (and administrators) can delete events
        if ($user instanceof Administrator) {
            return true;
        }
        else if ($user instanceof User) {
            return $user->id === $event->id_organizer;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public function restore(User $user, Event $event) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public function forceDelete(User $user, Event $event) {
        //
    }

    public static function answerPolls(?User $user, Event $event) {
        // Only event participants can answer polls
        return $event->participants()->wherePivot('id_user', optional($user)->id)->first() !== null;
    }
}
