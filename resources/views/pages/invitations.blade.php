@extends('layouts.app')
@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invitations</li>
        </ol>
    </nav>

    <h1 class="text-center">Invitations</h1>
    
    <form method="POST" class="py-3" action="{{ route('events.event.invitations.new', ['id' => $event->id]) }}" id="sendInvitationForm">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" id="invite" name="invite" placeholder="Enter a username / email..." required>
            <button type="submit" class="btn btn-primary">Send invitation</button>
        </div>
        <p class="mb-0 mt-2 px-2 text-danger" id="invitationsError"></p>
    </form>

    <div class="row">
        <section id="sent" class="col-md mb-4 mb-md-0">
            <h4>Sent</h4>

            <form method="POST" action="{{ route('events.event.invitations.delete', ['id' => $event->id]) }}" class="form-delete-all-invitations">
                @csrf
                @method('DELETE')
                <button type="submit" name="cancelAllInvitations" class="btn btn-outline-danger">Cancel all</button>
            </form>
            <p class="mb-0 mt-2 px-2 text-danger" id="cancelInvitationsError"></p>

            <div class="d-flex flex-wrap mt-2 gap-3" id="invitations">
                @foreach ($event->invitations()->get() as $user)
                    @include('partials.invitation', ['user' => $user])
                @endforeach
            </div>
        </section>

        <section id="requests" class="col-md">
            <h4>Requests to participate</h4>

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('events.event.join-requests.update', ['id' => $event->id]) }}" class="form-manage-all-join-request">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Accepted">
                    <button type="submit" class="btn btn-outline-success">Accept all</button>
                </form>
                <form method="POST" action="{{ route('events.event.join-requests.update', ['id' => $event->id]) }}" class="form-manage-all-join-request">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Declined">
                    <button type="submit" class="btn btn-outline-danger">Reject all</button>
                </form>
            </div>
            <p class="mb-0 mt-2 px-2 text-danger" id="updateJoinRequestError"></p>

            <div class="d-flex flex-wrap mt-2 gap-3" id="join-requests">
                @foreach ($event->joinRequests()->get() as $user)
                    @include('partials.join_request', ['user' => $user])
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
