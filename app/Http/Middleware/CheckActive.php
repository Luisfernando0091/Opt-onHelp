<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->activo == 0) {

            Auth::logout(); // Cierra sesión

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Tu usuario está inactivo.']);
        }

        return $next($request);
    }
}
