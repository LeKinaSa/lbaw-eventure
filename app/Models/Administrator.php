<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrator extends Authenticatable {
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    
    protected $table = 'administrator';

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
    ];
}
