<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller {
    protected $redirectTo = '/';
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show the forgot password page.
     * This page should contain a form containing an email field as input.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show() {
        return view('auth.forgot_password');
    }

    /**
     * Send an email to the email present in the request.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request) {
        $request->validate(['email' => 'required|string|email|max:255']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? redirect(route('password.email.sent'))
                : back()->withErrors(['email' => __($status)]);
    }

    public function showEmailSent() {
        return view('auth.email_sent');
    }
}
