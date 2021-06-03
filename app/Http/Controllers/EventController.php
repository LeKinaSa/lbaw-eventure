<?php

namespace App\Http\Controllers;

use App\Utils;
use App\Models\Category;
use App\Models\User;
use App\Models\Event;
use App\Policies\EventPolicy;
use DB;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller {
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
            'picture' => 'nullable|file|image|max:1000',
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

        $pictureBase64 = NULL;
        $picture = $request->file('picture');

        if ($request->hasFile('picture') && $picture->isValid()) {
            $pictureBase64 = Utils::convertImageToBase64($picture);
            
            if (is_null($pictureBase64)) {
                return back()->withErrors(['picture' => 'Uploaded picture has unsupported extension.']);
            }
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
                'picture' => $pictureBase64,
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
        $user = Auth::user() ?? Auth::guard('admin')->user();
        $this->authorizeForUser($user, 'view', $event);

        $comments = $event->comments()->leftJoin('user', 'comment.id_author', '=', 'user.id')
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

        $pictureBase64 = NULL;
        $picture = $request->file('picture');

        if ($request->hasFile('picture') && $picture->isValid()) {
            $pictureBase64 = Utils::convertImageToBase64($picture);
            
            if (is_null($pictureBase64)) {
                return back()->withErrors(['picture' => 'Uploaded picture has unsupported extension.']);
            }
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
                'picture' => $pictureBase64,
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('events.event.edit', ['id' => $event->id]));
        }

        $event->save();
        return redirect(route('events.event', ['id' => $event->id]));
    }

    /**
     * Show the invitations page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showInvitations(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);
        return view('pages.invitations', ['event' => $event]);
    }

    /**
     * Show the participants page.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showParticipants(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);
        return view('pages.participants', ['event' => $event]);
    }

    public function updateParticipationValidator(Request $request) {
        return Validator::make($request->all(), [
            'status' => ['required', 'string', Rule::in(['Accepted', 'Declined'])],
        ]);
    }

    /**
     * Send an invitation to an user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createInvitation(Request $request, $id) {
        $event = Event::find($id);

        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        // Authorization
        $user = Auth::user();
        if (!EventPolicy::updateParticipation($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        if ($event->cancelled) {
            return response('The event has been cancelled.', 400);
        }

        // The input may be username or email
        $usernameOrEmail = $request->input('invite');

        // Obtain user
        $user = User::where('username', $usernameOrEmail)->orWhere('email', $usernameOrEmail)->first();
        if (is_null($user))  {
            return response('The given username or email does not match any user.', 400);
        }

        // Check if an invitation or join request already exists
        $participation = DB::table('participation')->where([['id_user', $user->id], ['id_event', $event->id]])->first();
        if (!is_null($participation)) {
            return response('An invitation or join request for the specified user already exists.', 400);
        }

        // Invite user
        try {
            DB::table('participation')->insert(['id_user' => $user->id, 'id_event' => $id, 'status' => 'Invitation']);
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('partials.invitation', ['user' => $user, 'event' => $event]);
    }

    /**
     * Manage an event invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String   $id
     * @param  int      $idEvent
     * @return \Illuminate\Http\Response
     */
    public function updateInvitation(Request $request, $username, $idEvent) {
        $event = Event::find($idEvent);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        $user = User::where('username', $username)->first();
        if (is_null($user)) {
            return response('User with the specified ID does not exist.', 404);
        }

        // Verify if the user is already in this event
        $participation = DB::table('participation')->where([['id_event', $event->id], ['id_user', $user->id], ['status', 'Invitation']])->first();
        if (is_null($participation)) {
            return response('User is not invited to this event.', 404);
        }

        // Validate request (check status input)
        $validator = $this->updateParticipationValidator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        // Authorization
        $authenticatedUser = Auth::user();
        if (!EventPolicy::updateInvitation($authenticatedUser, $user)) {
            return response('No permission to perform this request.', 403);
        }

        // Accept / Decline the invitation
        $status = $request->input('status');
        DB::beginTransaction();
        try {
            $participants = DB::table('participation')
                                ->where([['id_event', $event->id], ['id_user', $user->id], ['status', 'Invitation']])
                                ->update(['status' => $status]);
            if ($status === 'Accepted') {
                $event->update(['n_participants' => $event->n_participants + $participants]);
            }
        }
        catch (QueryException $ex) {
            DB::rollback();
            return response('The attendance limit for this event has been reached.', 400);
        }
        DB::commit();

        return view('partials.event_request_to_join', ['event' => $event]);
    }

    /**
     * Cancel the invitation of an user.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   int   $id
     * @param   int   $idUser
     * @return  \Illuminate\Http\Response
     */
    public function deleteInvitation(Request $request, $id, $idUser) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        $user = User::find($idUser);
        if (is_null($user)) {
            return response('User with the specified ID does not exist.', 404);
        }

        // Authorization
        $user = Auth::user();
        if (!EventPolicy::updateParticipation($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        try {
            DB::table('participation')
                    ->where([['id_event', $id], ['id_user', $idUser], ['status', 'Invitation']])
                    ->delete();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return response('');
    }

    /**
     * Cancel all the invitations for this event.
     *
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * @return  \Illuminate\Http\Response
     */
    public function deleteAllInvitations(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        // Authorization
        $user = Auth::user();
        if (!EventPolicy::updateParticipation($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        try {
            DB::table('participation')
                    ->where([['id_event', $id], ['status', 'Invitation']])
                    ->delete();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return response('');
    }

    /**
     * Send a request to join the event.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createJoinRequest(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        // Check if user is allowed to make a join request (Authorization)
        $user = Auth::user();
        if (!EventPolicy::requestToJoin($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        // Check if an invitation or join request already exists
        $participation = DB::table('participation')->where([['id_user', $user->id], ['id_event', $event->id]])->first();
        if (!is_null($participation)) {
            return response('An invitation or join request for the specified user already exists.', 400);
        }

        // Insert a new join request
        try {
            DB::table('participation')->insert([
                'id_user' => $user->id,
                'id_event' => $id,
                'status' => 'JoinRequest'
            ]);
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('partials.event_request_to_join', ['event' => $event]);
    }

    /**
     * Manage a request to join the event.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param int idUser
     * @return \Illuminate\Http\Response
     */
    public function updateJoinRequest(Request $request, $id, $idUser) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        $user = User::find($idUser);
        if (is_null($user)) {
            return response('User with the specified ID does not exist.', 404);
        }

        // Verify if the user has requested to join the event
        $participation = DB::table('participation')->where([['id_event', $id], ['id_user', $user->id], ['status', 'JoinRequest']])->first();
        if (is_null($participation)) {
            return response('User did not request to join this event.', 404);
        }

        // Validate request (check status input)
        $validator = $this->updateParticipationValidator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        // Authorization
        $authenticatedUser = Auth::user();
        if (!EventPolicy::updateParticipation($authenticatedUser, $event)) {
            return response('No permission to perform this request.', 403);
        }

        // Accept / decline the join request
        $status = $request->input('status');
        DB::beginTransaction();
        try {
            if (!is_null($event->max_attendance) && $event->n_participants === $event->max_attendance) {
                DB::rollBack();
                return response('The attendance limit has been reached.', 400);
            }

            $affected = DB::table('participation')
                    ->where('id_event', $id)
                    ->where('id_user', $user->id)
                    ->where('status', 'JoinRequest')
                    ->update(['status' => $status]);
            
            if ($status === 'Accepted') {
                $event->update(['n_participants' => $event->n_participants + $affected]);
            }
        }
        catch (QueryException $ex) {
            DB::rollBack();
            return response('A database error occurred.', 500);
        }
        DB::commit();

        return response('');
    }

    /**
     * Manage all the requests to join the event.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateAllJoinRequests(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        // Validate request (check status input)
        $validator = $this->updateParticipationValidator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        // Authorization
        $user = Auth::user();
        if (!EventPolicy::updateParticipation($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        // Accept / Decline all the join requests
        $status = $request->input('status');
        DB::beginTransaction();
        try {
            $participants = DB::table('participation')
                                ->where([['id_event', $id], ['status', 'JoinRequest']])
                                ->update(['status' => $status]);
            if ($status === 'Accepted') {
                $event->update(['n_participants' => $event->n_participants + $participants]);
            }
        }
        catch (QueryException $ex) {
            DB::rollback();
            return response('The event doesn\'t have enough space for all the join requests to participate.', 400);
        }
        DB::commit();

        return response('');
    }

    /**
     * Cancel the specified event.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }
        if ($event->cancelled) {
            return response('');
        }

        // Authorization
        $user = Auth::user();
        if (!EventPolicy::cancel($user, $event)) {
            return response('No permission to perform this request.', 403);
        }

        try {
            $event->update(['cancelled' => 'true']);
            DB::table('participation')->where([['id_event', $event->id], ['status', 'JoinRequest']])->update(['status' => 'Declined']);
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }
        return response(route('events.event', ['id' => $event->id]));
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

    /**
     * Returns the events that match the specified search request.
     * Queries are limited to a maximum of 50 events, to prevent generic searches.
     * @param \Illuminate\Http\Request $request
     */
    public function getSearchEvents(Request $request) {
        $query = $request->input('query');
        $sql = Event::join('user', 'user.id', '=', 'event.id_organizer')
                ->select('event.*', 'user.username', 'user.name')
                ->selectRaw('ts_rank(keywords, to_tsquery(\'english\', ?)) AS "rank"', [$query])
                ->whereRaw('keywords @@ to_tsquery(\'english\', ?)', [$query]);
        
        if ($request->input('startDate') !== null) {
            $sql = $sql->where('start_date', '>=', $request->input('startDate'));
        }

        if ($request->input('endDate') !== null) {
            $sql = $sql->where('end_date', '<=', $request->input('endDate'));
        }

        if ($request->input('category') !== null) {
            $sql = $sql->where('id_category', '=', $request->input('category'));
        }

        if ($request->input('types') !== null) {
            $types = explode(',', $request->input('types'));
            $sql = $sql->where(function ($query) use($types) {
                foreach ($types as $idx => $type) {
                    if ($idx === 0) {
                        $query->where('type', '=', $type);
                    }
                    else {
                        $query->orWhere('type', '=', $type);
                    }
                }
            });
        }

        $sql = $sql->orderBy('rank', 'desc')
                ->limit(50);
        
        $events = $sql->get()->filter(function($v) {
            $user = Auth::user() ?? Auth::guard('admin')->user();
            return EventPolicy::view($user, $v);
        });
        
        return $events;
    }

    private static function searchValidator(Request $request) {
        return Validator::make($request->all(), [
            'query' => 'required|string|max:500',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'category' => 'nullable|integer|exists:category,id',
            'types' => 'nullable|string',
        ]);
    }

    /**
     * Show the results page for event search.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showSearchResults(Request $request) {
        EventController::searchValidator($request)->validate();

        try {
            $events = $this->getSearchEvents($request);
        }
        catch (QueryException $e) {
            return response('A database error occurred.', 500);
        }

        $categories = Category::get();

        return view('pages.search_results', ['events' => $events, 'categories' => $categories]);
    }
    
    public function getSearchResults(Request $request) {
        $validator = EventController::searchValidator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        try {
            $events = $this->getSearchEvents($request);
        }
        catch (QueryException $e) {
            return response('A database error occurred.', 500);
        }

        return view('partials.search_results', ['events' => $events]);
    }
}
