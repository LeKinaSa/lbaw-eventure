<article class="card card-invitation">
    <div class="card-body">
        <h5 class="card-title text-center"><a href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></h5>
        <ul class="list-unstyled mb-0">
            <li class="card-text"><i class="fs-5 col-2 fa fa-info" aria-label="Date"></i>{{ $event->getTypeFormatted() }}</li>
            @if (!is_null($event->start_date))
            <li class="card-text"><i class="fs-5 col-2 fa fa-calendar" aria-label="Date"></i>{{ (new DateTime($event->start_date))->format('j M, Y H:i') }}</li>
            @endif
            @if (!is_null($event->location))
            <li class="card-text"><i class="fs-5 col-2 fa fa-map-marker" aria-label="Location"></i>{{ $event->location }}</li>
            @endif
        </ul>
    </div>
    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-evenly">
            <form method="POST" action="{{ route('users.user.invitations.invitation.update', ['username' => $user->username, 'idEvent' => $event->id]) }}" class="form-manage-invitation">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Accepted">
                <button type="submit" class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('users.user.invitations.invitation.update', ['username' => $user->username, 'idEvent' => $event->id]) }}" class="form-manage-invitation">
                @csrf
                @method('PATCH')
                <input type="hidden" id="status" name="status" value="Declined">
                <button type="submit" class="btn btn-danger" aria-label="Reject"><i class="fa fa-remove"></i></button>
            </form>
        </div>
    </div>
</article>
