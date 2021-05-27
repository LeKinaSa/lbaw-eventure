<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller {
    protected $redirectTo = '/';
    use ResetsPasswords;

    /**
     * Show the reset password page.
     * This page should contain a form containing the following inputs:
     * email, password, password_confirmation and hidden token
     * 
     * @param String $token - the email token (64 chars)
     * @return \Illuminate\Http\Response
     */
    public function show($token) {
        return view('auth.recover_password', ['token' => $token]);
    }

    /**
     * Reset the password of the account with the email and token of the request.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function recoverPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->update([
                    'password' => bcrypt($password)
                ]);
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = User::where('email', $request->input('email'))->first();
            if (!is_null($user)) {
                Auth::login($user);
            }
            return redirect(url('/'));
        }

        return back()->withErrors(['token' => [__($status)]]);
    }
}
