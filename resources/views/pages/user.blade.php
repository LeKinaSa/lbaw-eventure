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
            <div class="d-grid gap-2">
                @if (Auth::id() === $user->id)
                <a href="{{ route('users.profile.edit', ['username' => $user->username]) }}" role="button" class="btn btn-light border">Edit profile</a>
                @endif
                @if (!is_null(Auth::guard('admin')->user()))
                    @include('partials.suspension_ban_status')
                    @if (is_null($ban) && is_null($suspension))
                    <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#suspendUserModal">
                    Suspend user <i class="fa fa-calendar"></i>
                    </button>
                    @endif
                    @if (is_null($ban))
                    <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#banUserModal">
                    Ban user <i class="fa fa-ban"></i>
                    </button>
                    @endif
                @endif
            </div>

            @if (!is_null(Auth::guard('admin')->user()) && is_null($ban) && is_null($suspension))
            <div class="modal fade" id="suspendUserModal" tabindex="-1" aria-labelledby="suspendUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="suspendUserLabel">Suspend user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration (days) <span class="text-danger fw-bold">*</span></label>
                                    <input type="number" class="form-control" id="duration" name="duration" min="1" max="100" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="suspensionReason" class="form-label">Reason <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" class="form-control" id="suspensionReason" name="reason" required>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-warning" value="Suspend">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if (!is_null(Auth::guard('admin')->user()) && is_null($ban))
            <div class="modal fade" id="banUserModal" tabindex="-1" aria-labelledby="banUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="banUserLabel">Ban user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!--
                            <p><b>Warning:</b> deleting your account is irreversible. All the events you are organizing and
                            comments you have posted will be permanently deleted. Votes you made on polls will also be removed.</p>

                            <p>If you are sure you wish to delete your account, please enter your current password below.</p>
                            
                            <form method="POST" action="{{ route('users.profile.delete', ['username' => $user->username]) }}">
                                {{ csrf_field() }}

                                @method('DELETE')
                                <div class="mb-3">
                                    <label for="passwordDelete" class="form-label">Current Password *</label>
                                    <input type="password" class="form-control" id="passwordDelete" name="password" required>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </div>
                            </form>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-9 pt-3">
            <section id="eventsOrganizer" class="row bg-light m-2 p-3">
                <header class="d-flex align-items-center justify-content-between mb-2">
                    <h4>Events {{ Auth::id() === $user->id ? "you" : "they" }} are organizing</h4>
                    <a href="{{ route('users.profile.events', ['username' => $user->username]) }}" role="button" class="btn btn-primary text-uppercase">See all</a>
                </header>
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsOrganizing, 'event')
                </div>
            </section>

            <section id="eventsParticipant" class="row bg-light m-2 p-3">
                <header class="d-flex align-items-center justify-content-between mb-2">
                    <h4>Events {{ Auth::id() === $user->id ? "you" : "they" }} are participating in</h4>
                    <a href="{{ route('users.profile.events', ['username' => $user->username]) }}" role="button" class="btn btn-primary text-uppercase">See all</a>
                </header>
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsParticipatingIn, 'event')
                </div>
            </section>
        </div>
    </div>
</div>
@endsection