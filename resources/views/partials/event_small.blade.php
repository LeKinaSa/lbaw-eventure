
<article class="card card-profile" data-id="{{ $event->id }}">
    <img src="{{ is_null($event->picture) ? asset('img/event_default.png') : 'data:image/jpeg;base64, ' . $event->picture }}" class="card-img-top card-event-small">
    <div class="card-body">
        <h5 class="card-title text-center">
            <a class="text-primary" href="{{ route('events.event', $event) }}">{{ $event->title }}</a>
            <i class="fa {{ $event->visibility === 'Public' ? "fa-globe" : "fa-lock" }}"></i>
        </h5>
        <ul class="list-unstyled">
            <li class="card-text"><i class="fs-5 col-2 fa fa-info" aria-label="Date"></i>{{ $event->getTypeFormatted() }}</li>
            @if (!is_null($event->start_date))
            <li class="card-text"><i class="fs-5 col-2 fa fa-calendar" aria-label="Date"></i>{{ $event->start_date }}</li>
            @endif
            @if (!is_null($event->location))
            <li class="card-text"><i class="fs-5 col-2 fa fa-map-marker" aria-label="Location"></i>{{ $event->location }}</li>
            @endif
            {{-- <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i> participants</li> --}}
        </ul>
    </div>
</article>