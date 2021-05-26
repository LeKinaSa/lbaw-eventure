
@php
$from = new DateTime($suspension->from);
$until = new DateTime($suspension->until);
$duration = $until->diff($from);
@endphp

<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-md-flex gap-3 align-items-center">
        <div class="mb-1">
            <h5 class="card-title mb-0">{{ $suspension->name }}</h5>
            <h6 class="text-primary mb-0"><a href="{{ route('users.profile', ['username' => $suspension->username]) }}">&commat;{{ $suspension->username }}</a></h6>
        </div>

        <ul class="list-unstyled mb-0">
            <li class="card-text"><b>Suspension date:</b> {{ $from->format('j M, Y') }}</li>
            <li class="card-text"><b>Suspension duration:</b> {{ $duration->days . ($duration->days > 1 ? ' days' : ' day') }}</li>
            <li class="card-text"><b>Reason:</b> {{ $suspension->reason }}</li>
        </ul>
    </div>

    <div class="d-flex gap-1 flex-column">
        <button class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
        <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
    </div>
</li>