<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policies\EventPolicy;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            // A valid image was uploaded
            // TODO: move this to a separate function

            list($width, $height) = getimagesize($picture);

            if ($picture->extension() === 'png') {
                $original = imagecreatefrompng($picture);
            }
            else if ($picture->extension() === 'jpeg' || $picture->extension() === 'jpg') {
                $original = imagecreatefromjpeg($picture);
            }
            else {
                return back()->withErrors(['picture' => 'Uploaded picture has an unsupported extension.']);
            }

            $square = min($width, $height);

            // Resize the uploaded image to 500x500 pixels
            $resized = imagecreatetruecolor(500, 500);
            imagecopyresized($resized, $original, 0, 0, ($width > $square) ? ($width - $square) / 2 : 0,
                    ($height > $square) ? ($height - $square) / 2 : 0, 500, 500, $square, $square);

            // Using output buffering to store the result of imagejpeg into a string
            ob_start();
            imagejpeg($resized);
            $pictureString = ob_get_contents(); // Read string from buffer
            ob_end_clean();

            $pictureBase64 = base64_encode($pictureString);
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
        return view('pages.user_events');
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
