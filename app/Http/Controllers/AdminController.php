<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function showUserManagement() {
        return view('pages.user_management');
    }
}
