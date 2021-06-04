<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\Suspension;
use App\Models\User;
use App\Utils;
use App\Policies\EventPolicy;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller {
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $username) {
        $user = User::where('username', $username)->firstOrFail();
        $authenticatedUser = Auth::user() ?? Auth::guard('admin')->user();
        $this->authorizeForUser($authenticatedUser, 'view', $user);

        $eventsOrganizing = $user->eventsOrganizing()->limit(3)->get();
        foreach ($eventsOrganizing as $key => $event) {
            if (!EventPolicy::view($authenticatedUser, $event)) {
                unset($eventsOrganizing[$key]);
            }
        }

        $eventsParticipatingIn = $user->eventsParticipatingIn()->limit(3)->get();
        foreach ($eventsParticipatingIn as $key => $event) {
            if (!EventPolicy::view($authenticatedUser, $event)) {
                unset($eventsParticipatingIn[$key]);
            }
        }

        $suspension = Suspension::where('id_user', $user->id)->where('until', '>', date('Y-m-d'))->first();
        $ban = BannedUser::where('id_user', $user->id)->first();

        return view('pages.user', ['user' => $user, 'eventsOrganizing' => $eventsOrganizing, 'eventsParticipatingIn' => $eventsParticipatingIn,
                'suspension' => $suspension, 'ban' => $ban]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function edit($username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('update', $user);
        return view('pages.user_edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:100', Rule::unique('user')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('user')->ignore($user->id)],
            'location' => 'nullable|string|max:500',
            'gender' => ['nullable', 'string', Rule::in(['Unspecified', 'Male', 'Female', 'Other'])],
            'age' => 'nullable|integer|min:13|max:150',
            'website' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'picture' => 'nullable|file|image|max:1000',
        ]);

        $pictureBase64 = NULL;
        $picture = $request->file('picture');

        if ($request->hasFile('picture') && $picture->isValid()) {
            $pictureBase64 = Utils::convertImageToBase64($picture);

            if (is_null($pictureBase64)) {
                return back()->withErrors(['picture' => 'Uploaded picture has unsupported extension.']);
            }
        }

        $gender = $request->input('gender') === 'Unspecified' ? NULL : $request->input('gender');
        
        try {
            $user->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'address' => $request->input('location'),
                'gender' => $gender,
                'age' => $request->input('age'),
                'website' => $request->input('website'),
                'description' => $request->input('description'),
                'picture' => $pictureBase64,
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('users.profile.edit', ['username' => $user->username]));
        }

        $user->save();
        return redirect(route('users.profile', ['username' => $user->username]));
    }

    public static function passwordValidator(Request $request) {
        return Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);
    }

    public function updatePassword(Request $request, $username) {
        $user = User::where('username', $username)->first();

        if (is_null($user)) {
            return response('User with the specified username does not exist.', 400);
        }

        if (!UserPolicy::update(Auth::user(), $user)) {
            return response('No permission to perform this request.', 403);
        }

        $validator = UserController::passwordValidator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        if (!password_verify($request->input('password'), $user->password)) {
            return response('Current password does not match our records.', 400);
        }

        try {
            $user->update([
                'password' => bcrypt($request->input('newPassword'))
            ]);
            $user->save();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return response('');
    }

    /**
     * Remove the user from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return  \Illuminate\Http\Response
     */
    public function delete(Request $request, $username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('delete', $user);

        // Confirm password before deleting account
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        if ($user->delete()) {
            // Account deletion was successful
            Auth::logout();
            return redirect(url('/'));
        }

        // Redirect back to edit profile
        return redirect(route('users.profile.edit', ['username' => $user->username]));
    }

    public function showEvents($username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('view', $user);

        $eventsOrganizing = $user->eventsOrganizing()->limit(3)->get();
        foreach ($eventsOrganizing as $key => $event) {
            if (!EventPolicy::view(Auth::user(), $event)) {
                unset($eventsOrganizing[$key]);
            }
        }

        $eventsParticipatingIn = $user->eventsParticipatingIn()->limit(3)->get();
        foreach ($eventsParticipatingIn as $key => $event) {
            if (!EventPolicy::view(Auth::user(), $event)) {
                unset($eventsParticipatingIn[$key]);
            }
        }

        return view('pages.user_events', ['user' => $user, 'eventsOrganizing' => $eventsOrganizing, 'eventsParticipatingIn' => $eventsParticipatingIn]);
    }

    public function showInvitations($username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('update', $user); // Other users cannot view a user's invitations

        return view('pages.user_invitations', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }
}
