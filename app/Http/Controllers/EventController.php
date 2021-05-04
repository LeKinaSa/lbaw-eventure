<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use DateTime;
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
     * Validates requests to create a new event or update an existing one.
     */
    private function validateRequest(Request $request) {
        $request->validate([
            'title' => 'required|string|max:250',
            'visibility' => ['required', 'string', Rule::in(['Public', 'Private'])],
            'description' => 'required|string|max:5000',
            'type' => ['required', 'string', Rule::in(['InPerson', 'Mixed', 'Virtual'])],
            'location' => 'nullable|string|max:250',
            'maxAttendance' => [Rule::requiredIf($request->has('switchLimitedAttendance')), 'nullable', 'integer', 'min:1', 'max:10000'],
            'category' => 'required|integer|exists:category,id',
            'startDate' => ['nullable', 'date_format:Y-m-d', Rule::requiredIf($request->has('startTime') && $request->startTime !== NULL)],
            'finishDate' => ['nullable', 'date_format:Y-m-d', Rule::requiredIf($request->has('finishTime') && $request->finishTime !== NULL)],
            'startTime' => 'nullable|date_format:H:i',
            'finishTime' => 'nullable|date_format:H:i',
        ]);
    }

    private function buildDates(Request $request) {
        $startDate = NULL;
        $finishDate = NULL;
        $startTimestamp = NULL;
        $finishTimestamp = NULL;

        if ($request->input('startDate') !== NULL) {    
            $startDate = new DateTime($request->input('startDate') . ' ' . $request->input('startTime'));
            $startTimestamp = $startDate->format('Y-m-d H:i');
        }

        if ($request->input('finishDate') !== NULL) {
            $finishDate = new DateTime($request->input('finishDate') . ' ' . $request->input('finishTime'));
            $finishTimestamp = $finishDate->format('Y-m-d H:i');
        }

        return [$startDate, $finishDate, $startTimestamp, $finishTimestamp];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->authorize('create', Event::class);

        $this->validateRequest($request);
        list($startDate, $finishDate, $startTimestamp, $finishTimestamp) = $this->buildDates($request);

        if ($startDate !== NULL && $finishDate !== NULL && $startDate > $finishDate) {
            return back()->withErrors([
                'startDate' => 'Start date cannot be after finish date.'
            ]);
        }

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
                'start_date' => $startTimestamp,
                'end_date' => $finishTimestamp,
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('events.new'));
        }
        
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

        $comments = $event->comments()->join('user', 'comment.id_author', '=', 'user.id')
                ->select('comment.*', 'user.name', 'user.username');
        $commentsByParent = array();

        foreach ($comments->get() as $comment) {
            $idParent = is_null($comment->id_parent) ? 0 : $comment->id_parent;

            if (array_key_exists($idParent, $commentsByParent)) {
                array_push($commentsByParent[$idParent], $comment);
            }
            else {
                $commentsByParent[$idParent] = array($comment);
            }
        }

        return view('pages.event', ['event' => $event, 'commentsByParent' => $commentsByParent]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);

        $this->validateRequest($request);
        list($startDate, $finishDate, $startTimestamp, $finishTimestamp) = $this->buildDates($request);

        if ($startDate !== NULL && $finishDate !== NULL && $startDate > $finishDate) {
            return back()->withErrors([
                'startDate' => 'Start date cannot be after finish date.'
            ]);
        }

        try {
            $event->update([
                'title' => $request->input('title'),
                'id_organizer' => Auth::id(),
                'visibility' => $request->input('visibility'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'location' => $request->input('location'),
                'max_attendance' => $request->has('switchLimitedAttendance') ? $request->input('maxAttendance') : NULL,
                'id_category' => $request->input('category'),
                'start_date' => $startTimestamp,
                'end_date' => $finishTimestamp,
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('events.event.edit', ['id' => $event->id]));
        }
        
        $event->save();
        return redirect(route('events.event', ['id' => $event->id]));
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
