<article class="col-md-6 mb-3">
    <h5>{{ $poll->question }}</h5>
    @php
    $options = $poll->optionsWithAnswerCount()->get();
    $total_answers = 0;
    foreach ($options as $option) {
        $total_answers += $option->answer_count;
    }
    @endphp
    <ul class="list-group">
        @foreach($options as $option)
        <li class="list-group-item d-flex justify-content-between" data-id="{{ $option->id }}">
            <span>{{ $option->option }}</span>
            <span class="text-primary">{{ $option->answer_count }} votes
            @if ($total_answers > 0)
            ({{ 100 * $option->answer_count / $total_answers }}%)
            @endif
            </span>
        </li>
        @endforeach
    </ul>
</article>