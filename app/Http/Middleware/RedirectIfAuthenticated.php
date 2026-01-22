<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            
            $titre = Auth()->user()->role_id==2 ? "DR": (in_array(Auth()->user()->sexe, ["Homme", "Maxculin"])? "M." : "Mme");
            flash()->primary('Bievenue '.$titre.' '.Auth()->user()->name.' ! Nous sommes heureux de vous revoir !');
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}
