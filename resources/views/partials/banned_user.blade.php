
@php
$since = new DateTime($bannedUser->since);
@endphp

<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-md-flex gap-3 align-items-center">
            <div class="mb-1">
                <h5 class="card-title mb-0">{{ $bannedUser->name }}</h5>
                <h6 class="text-primary mb-0"><a href="{{ route('users.profile', ['username' => $bannedUser->username]) }}">&commat;{{ $bannedUser->username }}</a></h6>
            </div>

            <ul class="list-unstyled mb-0">
                <li class="card-text"><b>Ban date:</b> {{ $since->format('j M, Y') }}</li>
                <li class="card-text"><b>Reason:</b> {{ $bannedUser->reason }}</li>
            </ul>
        </div>

        <div class="d-flex gap-1 flex-column">
            <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
        </div>
    </li>
</ul>