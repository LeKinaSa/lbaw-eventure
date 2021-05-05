
<article data-id="{{ $comment->id }}" class="border-start border-2">
    <div>
        <header class="bg-light px-2 py-1 d-flex align-items-center justify-content-between">
            <h5 class="m-0">{{ $comment->name }} (<a class="text-primary" href="{{ route('users.profile', ['username' => $comment->username]) }}">&commat;{{ $comment->username }}</a>)</h5>
            <div class="d-flex gap-1 comment-text">
                @if (App\Policies\CommentPolicy::create(Auth::user(), $event))
                <button type="button" class="btn btn-primary button-comment-reply" aria-label="Reply"><i class="fa fa-reply"></i></button>
                @endif
                @can ('update', $comment)
                <button type="button" class="btn btn-secondary button-comment-edit" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                @endcan
                @can ('delete', $comment)
                <button type="button" class="btn btn-danger button-comment-delete" aria-label="Delete"><i class="fa fa-remove"></i></button> 
                @endcan
            </div>
        </header>
        <div class="mt-2 mb-3 mx-3">
            <div class="mb-2 show-whitespace comment-text">{{ $comment->text }}</div>

            {{-- TODO: comment editing (hidden for now)
            @can ('update', $comment)
            @include('partials.comment_form_edit')
            @endcan
            --}}

            @if (App\Policies\CommentPolicy::create(Auth::user(), $event))
            @include('partials.comment_form', ['idParent' => $comment->id])
            @endif
        </div>
    </div>

    <section class="ms-4 ms-md-5">
    @if (array_key_exists($comment->id, $commentsByParent))
        @foreach ($commentsByParent[$comment->id] as $child)
            @include('partials.comment', ['comment' => $child, 'commentsByParent' => $commentsByParent])
        @endforeach
    @endif
    </section>
</article>