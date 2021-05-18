<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <h6 class="text-primary"><a href="{{ route('users.profile', ['username' => $user->username]) }}">{{ $user->username }}</a></h6>
    </div>
    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-evenly">
            <form method="POST" action="{{ route('events.event.join-requests.update', ['id' => $event->id, 'idUser' => $user->id]) }}" class="form-manage-join-request">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Accepted">
                <button type="submit" class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('events.event.join-requests.update', ['id' => $event->id, 'idUser' => $user->id]) }}" class="form-manage-join-request">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Declined">
                <button type="submit" class="btn btn-danger" aria-label="Reject"><i class="fa fa-remove"></i></button>
            </form>
        </div>
    </div>
</div>
