<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Suspension;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function showUserManagement() {
        $suspensions = Suspension::join('user', 'suspension.id_user', '=', 'user.id')
                ->select('suspension.*', 'user.username', 'user.name')
                ->get();

        return view('pages.user_management', ['suspensions' => $suspensions]);
    }
}
