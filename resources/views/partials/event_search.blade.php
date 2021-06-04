<article class="card">
    <div class="row g-0">
        <div class="bg-light col-md-3 d-flex align-items-center">
            <img src="{{ is_null($event->picture) ? asset('img/event_default.png') : 'data:image/jpeg;base64, ' . $event->picture }}" class="img-fluid">
        </div>
        <div class="col-md-9">
            <div class="card-body">
                <a class="text-primary" href="{{ route('events.event', $event) }}"><h5 class="card-title text-center">{{ $event->title }}</h5></a>
                <ul class="list-unstyled">
                    <li class="card-text"><i class="fs-5 col-1 fa fa-info" aria-label="Type"></i>{{ $event->getTypeFormatted() }}</li>
                    @if (!is_null($event->start_date))
                    <li class="card-text"><i class="fs-5 col-1 fa fa-calendar" aria-label="Date"></i>{{ (new DateTime($event->start_date))->format('j M, Y H:i') }}</li>
                    @endif
                    @if (!is_null($event->location))
                    <li class="card-text"><i class="fs-5 col-1 fa fa-map-marker" aria-label="Location"></i>{{ $event->location }}</li>
                    @endif
                </ul>
                <p>
                {{ $event->description }}
                </p>
            </div>
        </div>
    </div>
</article>