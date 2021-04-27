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

    public function participants() {
        
    }
}
