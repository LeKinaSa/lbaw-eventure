@php
$options = $poll->optionsWithAnswerCount()->get();
$total_answers = 0;
foreach ($options as $option) {
    $total_answers += $option->answer_count;
}

$canAnswer = App\Policies\EventPolicy::answerPolls(Auth::user(), $event);
$answer = optional(optional(optional(Auth::user())->pollAnswer($poll))->first())->id_poll_option;
@endphp

<article class="col-md-6 mb-3" data-id="{{ $poll->id }}">
    <header class="mb-2 mx-1 d-flex align-items-center justify-content-between">
        <h5>{{ $poll->question }}</h5>
        @if (App\Policies\PollPolicy::delete(Auth::user() ?? Auth::guard('admin')->user(), $poll))
        <form method="POST" action="{{ route('api.events.event.polls.poll.delete', ['id' => $event->id, 'idPoll' => $poll->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Delete this poll</button>
        </form>
        @endif
        @if (!is_null($answer))
        <form method="POST" action="{{ route('api.events.event.polls.poll.answer.delete', ['id' => $event->id, 'idPoll' => $poll->id]) }}" class="form-remove-poll-answer">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Remove answer</button>
        </form>
        @endif
    </header>

    <form method="POST" action="{{ route('api.events.event.polls.poll.answer.put', ['id' => $event->id, 'idPoll' => $poll->id]) }}">
        @csrf
        @method('PUT')       

        <ul class="list-group">
            @foreach($options as $option)
            <li class="list-group-item d-flex justify-content-between" data-id="{{ $option->id }}">
                <span>{{ $option->option }}</span>
                <div class="d-flex align-items-center gap-2">
                <span class="text-primary">{{ $option->answer_count }} vote{{ $option->answer_count === 1 ? '' : 's' }}
                @if ($total_answers > 0)
                ({{ 100 * $option->answer_count / $total_answers }}%)
                @endif
                </span>
                @if ($canAnswer)
                <div class="form-check">
                    <input class="form-check-input input-poll-answer" type="radio" name="option" value="{{ $option->id }}" {{ $option->id === $answer ? "checked" : "" }}>
                </div>
                @endif
                </div>
            </li>
            @endforeach
        </ul>
    </form>
</article>