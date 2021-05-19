<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller {
    use AuthenticatesUsers;

    // Where to redirect users after login.
    protected $redirectTo = '/admin/user-management';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function guard() {
        return Auth::guard('admin');
    }

    public function showLoginForm() {
        return view('auth.sign_in', ['adminAuth' => true]);
    }

    public function username() {
        return 'username';
    }
}