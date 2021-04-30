<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policies\EventPolicy;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('view', $user);

        // TODO: Improve this
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

        return view('pages.user', ['user' => $user, 'eventsOrganizing' => $eventsOrganizing, 'eventsParticipatingIn' => $eventsParticipatingIn]);
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
            ]);
        }
        catch (QueryException $ex) {
            return redirect(route('users.profile.edit', ['username' => $user->username]));
        }

        $user->save();
        return redirect(route('users.profile', ['username' => $user->username]));
    }

    /**
     * Remove the user from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return  \Illuminate\Http\Response
     */
    public function delete(Request $request, $username) {
        // Get the user
        $user = Auth::user();

        // Log the user out
        Auth::logout();

        // Delete the user
        $this->authorize('delete', $user);
        if ($this->delete($user)) {
            // Delete Sucessful
            return redirect(url('/'));
        }

        // Delete failed
        
        // Login the user again
        Auth::login($user);

        // Redirect back to edit profile
        return redirect(route('users.profile.edit', ['username' => $user->username]));
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
