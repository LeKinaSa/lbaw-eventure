<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <h6 class="text-primary"><a href="{{ route('users.profile', ['username' => $user->username]) }}">{{ $user->username }}</a></h6>
    </div>
    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-evenly">
            <form method="POST" action="{{ route('events.event.invitations.cancel', ['id' => $event->id, 'idInvitation' => $user->username]) }}">
                {{ csrf_field() }}

                @method('PATCH')
                <button type="submit" class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('events.event.invitations.cancel', ['id' => $event->id, 'idInvitation' => $user->username]) }}">
                {{ csrf_field() }}

                @method('PATCH')
                <button type="submit" class="btn btn-danger" aria-label="Reject"><i class="fa fa-remove"></i></button>
            </form>
        </div>
    </div>
</div>
