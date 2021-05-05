<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    public const MAX_LENGTH = 2000;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'comment';

    protected $fillable = [
        'id_author', 'id_event', 'id_parent', 'text', 'date',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'id_parent');
    }
}
