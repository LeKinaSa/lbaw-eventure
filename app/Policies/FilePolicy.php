<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use App\Models\Event;
use App\Models\Administrator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy {
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
     * @param  \App\Models\Authenticatable  $user
     * @param  \App\Models\File             $file
     * @return mixed
     */
    public static function view(?Authenticatable $user, File $file, $event) {
        return EventPolicy::view($user, $event);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public static function create(?User $user, Event $event) {
        // Only the organizer can upload files for an event
        return optional($user)->id === $event->id_organizer;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return mixed
     */
    public function update(User $user, File $file)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\File  $file
     * @return mixed
     */
    public static function delete(?Authenticatable $user, File $file) {
        if (!is_null($user) && $user instanceof Administrator) {
            // Admnistrators can delete any file
            return true;
        }
        $event = Event::find($file->id_event);
        return ($event !== null) && (optional($user)->id === $event->id_organizer);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return mixed
     */
    public function restore(User $user, File $file)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return mixed
     */
    public function forceDelete(User $user, File $file)
    {
        //
    }
}
