<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    /**
     * Validates a request to add a new comment or edit an existing one.
     */
    private static function validateRequest(Request $request) {
        $maxLength = Comment::MAX_LENGTH;
        $request->validate([
            'text' => 'string|max:' . $maxLength,
        ]);
    }

    /**
     * Store a newly created comment in the database.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id                              ID of the event the comment will be posted in
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('create', [Comment::class, $event]);
        CommentController::validateRequest($request);

        $idParent = $request->input('idParent');

        if (!is_null($idParent) && $event->comments()->where('id', $idParent)->first() === null) {
            return response('Parent comment does not belong to the specified event.', 400);
        }

        try {
            $comment = Comment::create([
                'id_event' => $id,
                'id_author' => Auth::id(),
                'id_parent' => $idParent,
                'text' => $request->input('text'),
            ]);
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        $comment->save();
        $comment = Comment::where('comment.id', $comment->id)->join('user', 'comment.id_author', '=', 'user.id')
                ->select('comment.*', 'user.name', 'user.username')->first();

        if ($request->acceptsHtml()) {
            return view('partials.comment', ['event' => $event, 'comment' => $comment, 'commentsByParent' => array()])->render();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment) {
        //
    }
}
