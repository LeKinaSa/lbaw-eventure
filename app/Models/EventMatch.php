<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMatch extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'match';

    protected $fillable = [
        'id_event', 'date', 'description', 'result', 'id_competitor1', 'id_competitor2',
    ];

    public function fromEvent() {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function competitor1() {
        return $this->belongsTo(Competitor::class, 'id_competitor1');
    }

    public function competitor2() {
        return $this->belongsTo(Competitor::class, 'id_competitor2');
    }

    
}