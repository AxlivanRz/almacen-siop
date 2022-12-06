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
            return route('inicio');
        }
        return redirect('/')->width('rol', 'No tienes los permisos para acceder a esta acción');
    }
}