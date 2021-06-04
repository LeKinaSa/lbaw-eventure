<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'file';

    protected $fillable = [
        'id_event', 'name', 'data',
    ];
    
    public function event() {
        return $this->belongsTo(Event::class, 'id_event');
    }
}
