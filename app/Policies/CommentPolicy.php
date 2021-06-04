<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Event;
use App\Models\Administrator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy {
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
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment) {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event $event
     * @return bool
     */
    public static function create(?User $user, Event $event) {
        // The organizer and the participants can post comments
        return optional($user)->id === $event->id_organizer 
                || $event->participants()->wherePivot('id_user', optional($user)->id)->first() !== null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public static function update(?User $user, Comment $comment) {
        return optional($user)->id === $comment->id_author;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public static function delete(?Authenticatable $user, Comment $comment) {
        if (!is_null($user) && $user instanceof Administrator) {
            // Admnistrators can delete any comment
            return true;
        }
        return optional($user)->id === $comment->id_author;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment) {
        //
    }
}
