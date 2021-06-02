
<form method="POST" action="{{ "" }}" class="form-comment-edit" hidden>
    @csrf
    <input type="hidden" name="idParent" value="{{ $comment->id_parent }}">    
    <textarea class="form-control mb-2" name="text" maxlength="{{ App\Models\Comment::MAX_LENGTH }}" required>{{ $comment->text }}</textarea>
    <input type="submit" class="btn btn-primary" value="Edit">
</form>