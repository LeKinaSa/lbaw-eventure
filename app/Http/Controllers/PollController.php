<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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

        $options = explode(';', $request->input('options'));

        if (count($options) <= 1) {
            abort(400, 'Poll requires a minimum of two options');
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
            abort(500, 'Database error');
        }

        if ($request->acceptsHtml()) {
            return view('partials.poll', ['poll' => $poll])->render();
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll) {
        //
    }
}
