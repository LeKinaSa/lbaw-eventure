
<form method="POST" action="{{ route('api.events.event.comments.new', ['id' => $event->id]) }}" class="form-comment-post" hidden>
    <input type="hidden" name="idParent" value="{{ $idParent }}">
    <textarea class="form-control mb-2" name="text" required></textarea>
    <input type="submit" class="btn btn-primary" value="Reply">
</form>
