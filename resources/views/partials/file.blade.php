<article class="card">
    <div class="card-body d-flex align-items-center gap-3">
        <div>
            <h5 class="card-title">{{ $file->name }}</h5>
            <p class="card-subtitle text-muted">Uploaded {{ (new DateTime($file->date_uploaded))->format('j M, Y H:i') }}</p>
        </div>
        <a role="button" class="btn btn-primary" href="{{ route('events.event.files.file', ['id' => $event->id, 'fileName' => $file->name]) }}"><i class="fa fa-download"></i></a>
    </div>
</article>