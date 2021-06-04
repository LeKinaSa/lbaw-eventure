<article class="card">
    <div class="card-body d-flex align-items-center gap-3">
        <div>
            <h5 class="card-title">{{ $file->name }}</h5>
            <p class="card-subtitle text-muted">Uploaded {{ (new DateTime($file->date_uploaded))->format('j M, Y H:i') }}</p>
        </div>
        <div class="d-flex flex-column align-items-center gap-1">
            <a role="button" class="btn btn-primary" href="{{ route('events.event.files.file', ['id' => $event->id, 'fileName' => $file->name]) }}"><i class="fa fa-download"></i></a>
            @if (App\Policies\FilePolicy::delete(Auth::user() ?? Auth::guard('admin')->user(), $file))
            <form method="POST" action="{{ route('events.event.files.delete', ['id' => $event->id, 'fileId' => $file->id]) }}" class="form-delete-file">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" aria-label="Delete File"><i class="fa fa-remove"></i></button>
            </form>
            @endif
        </div>
    </div>
</article>