<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;

    const FORMATTED_TYPES = [
        "InPerson" => "In person",
        "Mixed" => "Mixed",
        "Virtual" => "Virtual",
    ];

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    
    protected $table = 'event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'id_organizer', 'visibility', 'description', 'start_date', 'end_date',
        'type', 'location', 'max_attendance', 'cancelled', 'id_category', 
        'win_points', 'draw_points', 'loss_points', 'leaderboard',
    ];

    /**
     * The organizer of this event
     */
    public function organizer() {
        return $this->belongsTo(User::class, 'id_organizer');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'id_event');
    }

    public function polls() {
        return $this->hasMany(Poll::class, 'id_event');
    }

    /**
     * Returns all the users that have an entry in the participation table for this event, regardless of whether
     * they are actually participants in the event (they can be simply invited or attempting to join).
     */
    public function usersRelatedTo() {
        return $this->belongsToMany(User::class, 'participation', 'id_event', 'id_user')->withPivot('status');
    }

    public function participants() {
        return $this->usersRelatedTo()->where('status', 'Accepted');
    }

    public function invitations() {
        return $this->usersRelatedTo()->where('status', 'Invitation');
    }

    public function joinRequests() {
        return $this->usersRelatedTo()->where('status', 'JoinRequest');
    }

    public function getTypeFormatted() {
        return Event::FORMATTED_TYPES[$this->type];
    }

    public function limitedAttendance() {
        return $this->max_attendance !== null;
    }
}
