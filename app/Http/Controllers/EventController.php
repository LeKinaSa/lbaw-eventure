<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;

class EventController extends Controller {
    /**
     * Shows the event for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $event = Event::find($id);
        //$this->authorize('show', $event);
        return view('pages.event', ['event' => $event]);
    }

    /**
     * Creates a new event.
     *
     * @return Event The event created.
     */
    public function create(Request $request) {
        $event = new Event();
        
        $this->authorize('create', $event);

        $event->id_organizer = Auth::user()->id;

        $event->title          = $request->input('title');
        $event->visibility     = $request->input('visibility');
        $event->description    = $request->input('description');
        $event->picture        = $request->input('image');
        $event->start_date     = $request->input('startDate');  // TODO  startDate +  startTime
        $event->end_date       = $request->input('finishDate'); // TODO finishDate + finishTime
        $event->type           = $request->input('type');
        $event->location       = $request->input('location');
        $event->max_attendance = NULL;
        if ($request->input('switchLimitedAttendance')) {
            $event->max_attendance = $request->input('maxAttendance');
        }
        $event->cancelled      = false;
        $event->id_category    = $request->input('category');
        $event->win_points     = 1;
        $event->draw_points    = 0.5;
        $event->loss_points    = 0;
        $event->leaderboard    = false;
        
        // TODO: event keywords
        //$event->keywords       = ''; // TODO
        
        // TODO: Event Tags

        $event->save();
        return view('pages.event', ['id' => $event->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if ($id != 'new') {
            $event = Event::where('id', $id)->firstOrFail();
            $this->authorize('edit', $event);
            return view('pages.event_edit', ['id' => $event->id]);
        }
        return view('pages.event_edit', ['id' => $id]);
    }

    public function delete(Request $request, $id) {
      $event = Event::find($id);

      $this->authorize('delete', $event);
      
      $event->delete();
      return $event;
    }
}
