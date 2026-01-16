<?php

namespace App\Http\Middleware;

use Closure;

class Users
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
        $user = $request->user();

        if ($user && $user->role_id === 7) {
            return $next($request);
        }
        return redirect()->route('produits.pharmaceutique');
    }
}
