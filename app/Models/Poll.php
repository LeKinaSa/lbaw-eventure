<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model {
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table = 'poll';

    protected $fillable = [
        'id_event', 'question'
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function options() {
        return $this->hasMany(PollOption::class, 'id_poll');
    }

    public function optionsWithAnswerCount() {
        return $this->options()
                ->leftJoin('poll_answer', 'poll_option.id', '=', 'poll_answer.id_poll_option')
                ->selectRaw('poll_option.id, poll_option."option", count(poll_answer.id_user) AS answer_count')
                ->groupBy('poll_option.id');
    }
}
