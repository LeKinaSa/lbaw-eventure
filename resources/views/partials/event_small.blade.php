
<article class="card card-profile" data-id="{{ $event->id }}">
    <img src="{{ is_null($event->picture) ? asset('img/event_default.png') : 'data:image/jpeg;base64, ' . $event->picture }}" class="card-img-top card-event-small" alt="Event image">
    <div class="card-body">
        <h5 class="card-title text-center">
            <i class="text-danger {{ $event->cancelled ? "fa fa-ban" : "" }}" title="Event Cancelled" aria-label="Event Cancelled"></i>
            <a class="text-primary" href="{{ route('events.event', $event) }}">{{ $event->title }}</a>
            <i class="fa {{ $event->visibility === 'Public' ? "fa-globe" : "fa-lock" }}" title="{{ $event->visibility }} Event" aria-label="{{ $event->visibility }}"></i>
        </h5>
        <ul class="list-unstyled">
            <li class="card-text"><i class="fs-5 col-2 fa fa-info" aria-label="Date"></i>{{ $event->getTypeFormatted() }}</li>
            @if (!is_null($event->start_date))
            <li class="card-text"><i class="fs-5 col-2 fa fa-calendar" aria-label="Date"></i>{{ (new DateTime($event->start_date))->format('j M, Y H:i') }}</li>
            @endif
            @if (!is_null($event->location))
            <li class="card-text"><i class="fs-5 col-2 fa fa-map-marker" aria-label="Location"></i>{{ $event->location }}</li>
            @endif
        </ul>
    </div>
</article>