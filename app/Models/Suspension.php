<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'suspension';

    protected $fillable = [
        'id_user', 'from', 'until', 'reason',
    ];
}
