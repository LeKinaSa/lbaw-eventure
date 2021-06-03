<?php

namespace App\Http\Middleware;

use App\Models\BannedUser;
use App\Models\Suspension;
use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannedOrSuspended {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::check()) {
            $suspension = Suspension::where('id_user', Auth::id())->where('until', '>', date('Y-m-d'))->first();
            $ban = BannedUser::where('id_user', Auth::id())->first();

            if (is_null($suspension) && is_null($ban)) {
                return $next($request);
            }

            Auth::logout();

            if (!is_null($suspension)) {
                $message = 'Your account has been suspended until ' . (new DateTime($suspension->until))->format('j M, Y') . ' for: ' . $suspension->reason;
            }

            if (!is_null($ban)) {
                $message = 'Your account has been permanently banned for: ' . $ban->reason;
            }

            return redirect()->route('sign-in')->withMessage($message);
        }

        return $next($request);
    }

    
}
