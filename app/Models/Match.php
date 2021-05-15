<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'comment';

    protected $fillable = [
        'id_event', 'date', 'description', 'result', 'id_competitor1', 'id_competitor2',
    ];

    public function competitor1() {
        return $this->belongsTo(User::class, 'id_competitor1');
    }

    public function competitor2() {
        return $this->belongsTo(User::class, 'id_competitor2');
    }

    
}