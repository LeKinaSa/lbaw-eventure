<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Poll;
use App\Models\PollOption;
use App\Policies\EventPolicy;
use App\Policies\PollPolicy;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PollController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('create', [Poll::class, $event]);

        $options = explode('|', $request->input('options'));

        if (count($options) <= 1) {
            return response('A poll requires a minimum of two options.', 400);
        }

        try {
            $poll = Poll::create([
                'id_event' => $id,
                'question' => $request->input('question'),
            ]);
            $poll->save();

            foreach ($options as $option) {
                $pollOption = PollOption::create([
                    'id_poll' => $poll->id,
                    'option' => $option,
                ]);
                $pollOption->save();
            }
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        if ($request->acceptsHtml()) {
            return view('partials.poll', ['poll' => $poll, 'event' => $event])->render();
        }

        // TODO: JSON
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll) {
        //
    }

    /**
     * Delete the specified poll.
     * 
     * @param int $idEvent
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($idEvent, $id) {
        $poll = Poll::find($id);
        if (is_null($poll)) {
            return response('Request has an invalid poll id.', 400);
        }

        // Authentication
        $user = Auth::user() ?? Auth::guard('admin')->user();
        $this->authorizeForUser($user, 'delete', $poll);

        if (!PollPolicy::delete(Auth::user(), $event)) {
            return response('No permission to perform this request.', 403);
        }

        $event = Event::find($idEvent);
        if (is_null($event)) {
            return response('Request has an invalid event id.', 400);
        }

        if ($event->polls()->where('id', $id)->first() === NULL) {
            return response('The specified poll does not belong to the event.', 400);
        }

        try {
            $poll->delete();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return response('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll) {
        //
    }
    
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @param  int $idPoll
     * @return \Illuminate\Http\Response
     */
    public function putAnswer(Request $request, $id, $idPoll) {
        $user = Auth::user();

        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        $poll = Poll::find($idPoll);
        if (is_null($poll)) {
            return response('Poll with the specified ID does not exist.', 404);
        }

        // Check if user can answer polls from this event
        if (!EventPolicy::answerPolls($user, $event)) {
            return response('Unauthorized action: cannot answer polls from this event.', 403);
        }

        $option = $request->input('option');

        // Check if the specified option is part of the poll
        if (is_null($poll->options()->where('id', $option)->first())) {
            return response('The specified option is not part of the poll.', 400);
        }

        $answer = $user->pollAnswer($poll)->first();

        try {
            DB::table('poll_answer')->updateOrInsert(
                ['id_user' => $user->id, 'id_poll_option' => optional($answer)->id_poll_option],
                ['id_poll_option' => $option]
            );
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('partials.poll', ['poll' => $poll, 'event' => $event]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @param  int $idPoll
     * @return \Illuminate\Http\Response
     */
    public function deleteAnswer(Request $request, $id, $idPoll) {
        $user = Auth::user();

        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        $poll = Poll::find($idPoll);
        if (is_null($poll)) {
            return response('Poll with the specified ID does not exist.', 404);
        }

        // Check if user can answer polls from this event
        if (!EventPolicy::answerPolls($user, $event)) {
            return response('Unauthorized action: cannot answer polls from this event.', 403);
        }

        $answer = $user->pollAnswer($poll)->first();
        if (is_null($answer)) {
            return response('An answer to the specified poll does not exist.', 400);
        }

        try {
            $user->pollAnswer($poll)->delete();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('partials.poll', ['poll' => $poll, 'event' => $event]);
    }
}
