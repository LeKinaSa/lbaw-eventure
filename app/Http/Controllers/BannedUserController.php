<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannedUserController extends Controller {
    public function validator(Request $request) {
        return Validator::make($request->all(), [
            'reason' => 'required|string|max:300',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $username) {
        $user = User::where('username', $username)->first();
        if (is_null($user)) {
            return response('User with the specified username does not exist.', 404);
        }
        
        $ban = BannedUser::where('id_user', $user->id)->first();

        if (!is_null($ban)) {
            return response('The specified user is already banned.', 400);
        }

        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        try {
            $ban = BannedUser::create([
                'id_user' => $user->id,
                'since' => date('Y-m-d'),
                'reason' => $request->input('reason'),
            ]);
        }
        catch (QueryException $e) {
            return response('A database error occurred.', 500);
        }

        $ban->save();
        return view('partials.suspension_ban_status', ['suspension' => null, 'ban' => $ban]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BannedUser  $bannedUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BannedUser $bannedUser) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BannedUser  $bannedUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(BannedUser $bannedUser) {
        //
    }
}
