
@php
$participation = $event->usersRelatedTo()->wherePivot('id_user', Auth::id())->first();
@endphp

@if (is_null($participation) && App\Policies\EventPolicy::requestToJoin(Auth::user(), $event))
<p class="mb-0 text-danger" id="joinRequestError"></p>
<a href="{{ route('events.event.join-requests.new', ['id' => $event->id]) }}" id="joinRequestButton" role="button" class="btn btn-primary">Request to Join <i class="fa fa-users"></i></a>
@elseif (!is_null($participation))
    @switch ($participation->pivot->status)
        @case ('Accepted')
            <p class="mb-0 text-success">You are participating in this event</p>
            @break
        @case ('Declined')
            <p class="mb-0 text-danger">You declined an invitation to this event or your request to join has been declined</p>
            @break
        @case ('JoinRequest')
            <p class="mb-0 text-muted">You have requested to join this event</p>
            @break
        @case ('Invitation')
            <form method="POST" action="{{ route('users.user.invitations.invitation.update', ['id' => $event->id, 'idUser' => $user->id]) }}" class="form-manage-invitation">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Accepted">
                <button type="submit" class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('users.user.invitations.invitation.update', ['id' => $event->id, 'idUser' => $user->id]) }}" class="form-manage-invitation">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Declined">
                <button type="submit" class="btn btn-danger" aria-label="Reject"><i class="fa fa-remove"></i></button>
            </form>
            @break
        @default
            @break
    @endswitch
@endif