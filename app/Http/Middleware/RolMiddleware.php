<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (auth()->check()) {
            foreach($roles as $rol){
                if (auth()->user()->hasRol($rol)) {
                    return $next($request);
                }
            }
           return redirect('/inicio')->with('status2', "no tienes los permisos necesarios");
        }
        return redirect('/login')
        ->with('status2', "inicia sesión para poder acceder");
    }
}