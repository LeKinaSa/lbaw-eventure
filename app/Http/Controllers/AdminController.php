<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\BannedUser;
use App\Models\Suspension;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function showUserManagement() {
        $suspensions = Suspension::join('user', 'suspension.id_user', '=', 'user.id')
                ->select('suspension.*', 'user.username', 'user.name')
                ->get();
        
        $bannedUsers = BannedUser::join('user', 'banned_user.id_user', '=', 'user.id')
                ->select('banned_user.*', 'user.username', 'user.name')
                ->get();

        return view('pages.user_management', ['suspensions' => $suspensions, 'bannedUsers' => $bannedUsers]);
    }
}
