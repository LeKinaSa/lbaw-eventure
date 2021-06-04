<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Event;
use App\Models\Competitor;
use App\Models\EventMatch;
use App\Policies\EventPolicy;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MatchController extends Controller {
    public static function validator(Request $request) {
        return Validator::make($request->all(), [
            'description' => 'nullable|string|max:500',
            'date' => ['nullable', 'date_format:Y-m-d', Rule::requiredIf($request->has('time'))],
            'time' => 'nullable|date_format:H:i',
            'result' => ['required', 'string', Rule::in(['TBD', 'Winner1', 'Winner2', 'Tie'])],
            'first' => 'required|integer|exists:competitor,id|different:second',
            'second' => 'required|integer|exists:competitor,id',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        if (!EventPolicy::update(Auth::user(), $event)) {
            return response('No permission to perform this request.', 403);
        }

        $validator = MatchController::validator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        $first = Competitor::where('id_event', $id)->where('id', $request->input('first'))->first();
        $second = Competitor::where('id_event', $id)->where('id', $request->input('second'))->first();

        if (is_null($first)) {
            return response('First competitor is not part of the specified event.', 400);
        }

        if (is_null($second)) {
            return response('Second competitor is not part of the specified event.', 400);
        }

        $fullDate = null;

        $date = $request->input('date');
        $time = $request->input('time');

        if (!is_null($time)) {
            $fullDate = $date . ' ' . $time;
        }
        else if (!is_null($date)) {
            $fullDate = $date;
        }

        if ($fullDate !== null) {
            $dt = new DateTime($fullDate);

            if ((!is_null($event->start_date) && $dt < new DateTime($event->start_date)) || (!is_null($event->end_date) && $dt > new DateTime($event->end_date))) {
                return response('Match date must be between event start and end dates.', 400);
            }
        }

        try {
            $match = EventMatch::create([
                'id_event' => $id,
                'date' => $fullDate,
                'description' => $request->input('description'),
                'result' => $request->input('result'),
                'id_competitor1' => $request->input('first'),
                'id_competitor2' => $request->input('second'),
            ]);
            $match->save();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        $match = $event->matches()->where('match.id', $match->id)
                ->join('competitor AS c1', 'c1.id', '=', 'match.id_competitor1')
                ->join('competitor AS c2', 'c2.id', '=', 'match.id_competitor2')
                ->select('match.*', 'c1.name AS name_competitor1', 'c2.name AS name_competitor2')->first();

        $leaderboard = null;
        if ($event->leaderboard) {
            $matches = $event->matches()
                ->join('competitor AS c1', 'c1.id', '=', 'match.id_competitor1')
                ->join('competitor AS c2', 'c2.id', '=', 'match.id_competitor2')
                ->select('match.*', 'c1.name AS name_competitor1', 'c2.name AS name_competitor2')->get();

            $competitors = $event->competitors()->get();

            $leaderboard = EventController::buildLeaderboard($event, $matches, $competitors);
        }
        
        $json = ['match' => view('partials.match', ['match' => $match])->render(), 'leaderboard' => view('partials.leaderboard', ['leaderboard' => $leaderboard])->render()];

        return response()->json($json);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventMatch  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(EventMatch $match) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventMatch  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventMatch $match) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventMatch  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventMatch $match) {
        //
    }
}
