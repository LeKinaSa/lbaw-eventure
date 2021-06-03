<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use App\Models\Event;
use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PollPolicy
{
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poll  $poll
     * @return mixed
     */
    public function view(User $user) {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public static function create(?User $user, Event $event) {
        // Only the organizer can create polls for an event
        return optional($user)->id === $event->id_organizer;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poll  $poll
     * @return mixed
     */
    public function update(User $user, Poll $poll) {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poll  $poll
     * @return mixed
     */
    public function delete(?Authenticatable $user, Poll $poll) {
        // TODO: check the next if statement
        if (is_null($user)) {
            $user = Auth::user() ?? Auth::guard('admin')->user();
        }
        
        if (!is_null($user) && $user instanceof Administrator) {
            // Admnistrators can delete any poll
            return true;
        }
        $event = Event::find($poll->id_event);
        return ($event !== null) && (optional($user)->id === $event->id_organizer);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poll  $poll
     * @return mixed
     */
    public function restore(User $user, Poll $poll) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poll  $poll
     * @return mixed
     */
    public function forceDelete(User $user, Poll $poll) {
        //
    }
}
