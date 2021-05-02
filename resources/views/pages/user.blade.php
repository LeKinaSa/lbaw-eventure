@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3 pt-3">
            <a class="text-primary" href="#">
                <img src="{{ is_null($user->picture) ? asset('img/profile_default.png') : 'data:image/jpeg;base64, ' . $user->picture }}" class="img-fluid d-block mx-auto rounded-circle mb-3" alt="Profile picture">
            </a>
            <h1>{{ $user->name }}</h1>
            <h4 class="text-primary">&commat;{{ $user->username }}</h4>
            <p class="text-break">{{ $user->description }}</p>
            <ul class="list-unstyled">
                <li class="h5" aria-label="Email"><i class="col-1 fa fa-envelope"></i> {{ $user->email }}</li>
                @if (!is_null($user->address))
                <li class="h5" aria-label="Location"><i class="col-1 fa fa-map-marker"></i> {{ $user->address }}</li>
                @endif
                @if (!is_null($user->gender))
                <li class="h5" aria-label="Gender"><i class="col-1 fa fa-user"></i> {{ $user->gender }}</li>
                @endif
                @if (!is_null($user->age))
                <li class="h5" aria-label="Age"><i class="col-1 fa fa-calendar"></i> {{ $user->age }} years old</li>
                @endif
                @if (!is_null($user->website))
                <li class="h5" aria-label="Website"><i class="col-1 fa fa-link"></i> <a class="text-primary" href="{{ $user->website }}">{{ $user->website }}</a></li>
                @endif
            </ul>
            @if (Auth::id() === $user->id)
            <div class="d-grid">
                <a href="{{ route('users.profile.edit', ['username' => $user->username]) }}" role="button" class="btn btn-light border">Edit profile</a>
            </div>
            @endif
        </div>

        <div class="col-md-9 pt-3">
            <section id="eventsOrganizer" class="row bg-light m-2 p-3">
                <header class="d-flex align-items-center justify-content-between mb-2">
                    <h4>Events {{ Auth::id() === $user->id ? "you" : "they" }} are organizing</h4>
                    <a href="personal_events.php" class="btn btn-primary text-uppercase">See all</a>
                </header>
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsOrganizing, 'event')
                </div>
            </section>

            <section id="eventsParticipant" class="row bg-light m-2 p-3">
                <header class="d-flex align-items-center justify-content-between mb-2">
                    <h4>Events {{ Auth::id() === $user->id ? "you" : "they" }} are participating in</h4>
                    <a href="personal_events.php" class="btn btn-primary text-uppercase">See all</a>
                </header>
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsParticipatingIn, 'event')
                </div>
            </section>
        </div>
    </div>
</div>
@endsection