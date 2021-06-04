<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Event;
use App\Policies\EventPolicy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompetitorController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $event = Event::findOrFail($id);

        $user = Auth::user() ?? Auth::guard('admin')->user();
        $this->authorizeForUser($user, 'view', $event);

        return view('pages.competitors', ['event' => $event, 'competitors' => $event->competitors()->get()]);
    }

    public static function validator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'string|max:300'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   int $id
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

        $validator = CompetitorController::validator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        if (!is_null(Competitor::where([['id_event', $id], ['name', $request->input('name')]])->first())) {
            return response('A competitor with the specified name already exists in this event.', 400);
        }

        try {
            $competitor = Competitor::create([
                'id_event' => $id,
                'name' => $request->input('name'),
            ]);
            $competitor->save();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('partials.competitor', ['event' => $event, 'competitor' => $competitor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competitor  $competitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competitor $competitor) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Competitor  $competitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competitor $competitor)
    {
        //
    }
}
