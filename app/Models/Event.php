<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    
    protected $table = 'event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'visibility', 'description', 'picture', 'keywords', 'start_date', 'end_date',
        'type', 'location', 'max_attendance', 'cancelled', 'win_points', 'draw_points',
        'loss_points', 'leaderboard',
    ];

    /**
     * The organizer of this event
     */
    public function organizer() {
        return $this->belongsTo('App\Models\User');
    }
}
