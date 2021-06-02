<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedUser extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'banned_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_user', 'since', 'reason',
    ];
}
