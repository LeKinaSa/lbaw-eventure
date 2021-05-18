<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable {
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'address', 
        'gender', 'age', 'website', 'description', 'picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Returns all the events that have an entry in the participation table for this user, regardless of whether
     * the user is actually participating in the event (they can be simply invited or attempting to join).
     */
    public function eventsRelatedTo() {
        return $this->belongsToMany(Event::class, 'participation', 'id_user', 'id_event')->withPivot('status');
    }

    public function eventsOrganizing() {
        return $this->hasMany(Event::class, 'id_organizer');
    }

    public function eventsParticipatingIn() {
        return $this->eventsRelatedTo()->where('status', 'Accepted');
    }

    public function pollAnswer(Poll $poll) {
        $options = $poll->options()->select('id');
        return DB::table('poll_answer')->where('id_user', $this->id)->whereIn('id_poll_option', $options);
    }
}
