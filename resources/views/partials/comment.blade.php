
<article data-id="{{ $comment->id }}">
    <div class="d-flex align-items-start justify-content-between">
        <h5>{{ $comment->name }} (<a class="text-primary" href="{{ route('users.profile', ['username' => $comment->username]) }}">&commat;{{ $comment->username }}</a>)</h5>
        <div class="d-flex gap-1">
            <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
        </div>
    </div>
    <div class="ps-3 pb-3 show-whitespace">{{ $comment->text }}</div>

    @if (array_key_exists($comment->id, $commentsByParent))
        <section class="ps-5">
        @foreach ($commentsByParent[$comment->id] as $child)
            @include('partials.comment', ['comment' => $child, 'commentsByParent' => $commentsByParent])
        @endforeach
        </section>
    @endif
</article>