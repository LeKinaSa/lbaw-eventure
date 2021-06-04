
<article data-id="{{ $comment->id }}" class="border-start border-2">
    @include('partials.comment')

    <section class="ms-4 ms-md-5 comment-children">
    @if (array_key_exists($comment->id, $commentsByParent))
        @foreach ($commentsByParent[$comment->id] as $child)
            @include('partials.comment_thread', ['comment' => $child])
        @endforeach
    @endif
    </section>
</article>