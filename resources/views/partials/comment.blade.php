<div class="comment">
    <header class="bg-light px-2 py-1 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="m-0">
            @if (is_null($comment->id_author))
            [deleted]
            @else
            {{ $comment->name }} (<a class="text-primary" href="{{ route('users.profile', ['username' => $comment->username]) }}">&commat;{{ $comment->username }}</a>)
            @endif
            </h5>
            <span>{{ (new DateTime($comment->date))->format('j M, Y H:i:s') }}</span>
        </div>
        <div class="d-flex gap-1 comment-text">
            @if (App\Policies\CommentPolicy::create(Auth::user(), $event) && !is_null($comment->id_author))
            <button type="button" class="btn btn-primary button-comment-reply" aria-label="Reply"><i class="fa fa-reply"></i></button>
            @endif
            @can ('update', $comment)
            <button type="button" class="btn btn-secondary button-comment-edit" aria-label="Edit"><i class="fa fa-pencil"></i></button>
            @endcan
            @if (App\Policies\CommentPolicy::delete(Auth::user() ?? Auth::guard('admin')->user(), $comment))
            <form method="POST" action="{{ route('api.events.event.comments.comment.delete', ['idEvent' => $event->id, 'id' => $comment->id]) }}">
            @csrf
            @method ('delete')
            <button type="submit" class="btn btn-danger button-comment-delete" aria-label="Delete"><i class="fa fa-remove"></i></button>
            </form>
            @endif
        </div>
    </header>
    <div class="mt-2 mb-3 mx-3">
        <p class="mb-2 show-whitespace comment-text">{{ is_null($comment->text) ? "[deleted]" : $comment->text }}</p>

        {{-- TODO: comment editing (hidden for now)
        @can ('update', $comment)
        @include('partials.comment_form_edit')
        @endcan
        --}}

        @if (App\Policies\CommentPolicy::create(Auth::user(), $event) && !is_null($comment->id_author))
        @include('partials.comment_form', ['idParent' => $comment->id])
        @endif
    </div>
</div>
