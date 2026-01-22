<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();
        $user = User::find($userId);

        if ($user->role_id == 1) {
            return $next($request);
        }else{
            return redirect('home');
        }
    }
}
