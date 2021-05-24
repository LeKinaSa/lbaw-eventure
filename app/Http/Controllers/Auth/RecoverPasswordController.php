<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
// use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class RecoverPasswordController extends Controller {
    protected $redirectTo = '/';
    use SendsPasswordResetEmails;
    // use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * The view that is returned by this route should have a form containing an email field,
     * which will allow the user to request a password reset link for a given email address.
     */
    public function showForgotPasswordForm() {
        // TODO: authorization
        return view('auth.forgot_password');
    }

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|string|email|max:255']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? view('auth.email_sent')
                : back()->withErrors(['email' => __($status)]);
    }
    
    /**
     * The view that is returned by this route should display a form containing 
     * an email field, a password field, a password_confirmation field,
     * and a hidden token field, which should contain the value of the secret $token
     * received by our route.
     */
    public function showRecoverPasswordForm($token) {
        // TODO: authorization
        return view('auth.recover_password', ['token' => $token]);
    }

    public function recoverPassword(Request $request) {
        // TODO: This function still doesn't work
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
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
        
        if ($status === Password::PASSWORD_RESET) {
            dd($status);
            return view('auth.email_sent');
        }
        else {
            return back()->withErrors(['token' => [__($status)]]);
        }
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status)) // TODO
                    : back()->withErrors(['token' => [__($status)]]);
    }
}
