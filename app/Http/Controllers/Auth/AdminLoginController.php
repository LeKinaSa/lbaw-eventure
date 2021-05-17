<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller {
    use AuthenticatesUsers;

    // Where to redirect users after login.
    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function guard() {
        return Auth::guard('admin');
    }

    public function showLoginForm() {
        return view('auth.sign_in');
    }
}