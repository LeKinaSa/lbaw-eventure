<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
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
        $this->authorize('create', Event::class);
        $categories = Category::get();
        
        return view('pages.event_edit', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:250',
            'visibility' => ['required', 'string', Rule::in(['Public', 'Private'])],
            'description' => 'required|string|max:5000',
            'type' => ['required', 'string', Rule::in(['InPerson', 'Mixed', 'Virtual'])],
            'location' => 'nullable|string|max:250',
            'maxAttendance' => [Rule::requiredIf($request->has('switchLimitedAttendance')), 'integer', 'min:1', 'max:10000'],
            'category' => 'required|integer|exists:category,id',
            'startDate' => 'nullable|date_format:Y-m-d',
            'endDate' => 'nullable|date_format:Y-m-d|after_or_equal:start_date'
        ]);

        $this->authorize('create', Event::class);

        try {
            $event = Event::create([
                'title' => $request->input('title'),
                'id_organizer' => Auth::id(),
                'visibility' => $request->input('visibility'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'location' => $request->input('location'),
                'max_attendance' => $request->has('switchLimitedAttendance') ? $request->input('maxAttendance') : NULL,
                'id_category' => $request->input('category'),
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('events.new'));
        }

        //$event->picture        = $request->input('image');
        //$event->start_date     = $request->input('startDate');  // TODO  startDate +  startTime
        //$event->end_date       = $request->input('finishDate'); // TODO finishDate + finishTime
        
        // TODO: Event Tags

        $event->save();
        return redirect(route('events.event', ['id' => $event->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $event = Event::findOrFail($id);
        $this->authorize('view', $event);
        return view('pages.event', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);

        $categories = Category::get();
        return view('pages.event_edit', ['event' => $event, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event) {
        //
    }
}
