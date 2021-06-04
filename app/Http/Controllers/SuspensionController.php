<?php

namespace App\Http\Controllers;

use App\Models\Suspension;
use App\Models\User;
use App\Models\BannedUser;
use DateInterval;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuspensionController extends Controller {
    public function validator(Request $request) {
        return Validator::make($request->all(), [
            'duration' => 'required|integer|min:1|max:100',
            'reason' => 'required|string|max:300',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  string                       $username
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $username) {
        $user = User::where('username', $username)->first();
        if (is_null($user)) {
            return response('User with the specified username does not exist.', 404);
        }
        
        // TODO: maybe we need a DB trigger?
        $suspension = Suspension::where('id_user', $user->id)->where('until', '>=', date('Y-m-d'))->first();
        $ban = BannedUser::where('id_user', $user->id)->first();

        if (!is_null($suspension)) {
            return response('The specified user is already suspended.', 400);
        }

        if (!is_null($ban)) {
            return response('The specified user is already banned.', 400);
        }

        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }

        $interval = new DateInterval('P' . $request->input('duration') . 'D');
        $until = date_add(new DateTime(date('Y-m-d')), $interval);

        try {
            $suspension = Suspension::create([
                'id_user' => $user->id,
                'from' => date('Y-m-d'),
                'until' => $until->format('Y-m-d'),
                'reason' => $request->input('reason'),
            ]);
        }
        catch (QueryException $e) {
            return response('A database error occurred.', 500);
        }

        $suspension->save();
        return view('partials.suspension_ban_status', ['suspension' => $suspension, 'ban' => $ban]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suspension  $suspension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suspension $suspension) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suspension  $suspension
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suspension $suspension) {
        //
    }
}
