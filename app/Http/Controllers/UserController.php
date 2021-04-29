<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
    public function show($username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('show', $user);

        $eventsOrganizing = Event::where('id_organizer', $user->id)->limit(3)->get();
        return view('pages.user', ['user' => $user, 'eventsOrganizing' => $eventsOrganizing]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function edit($username) {
        $user = User::where('username', $username)->firstOrFail();
        $this->authorize('edit', $user);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }
}
