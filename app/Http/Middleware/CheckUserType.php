<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        foreach ($roles as $role) {
            if ($role === 'admin') {
                return $next($request);
            }
            if ($role === 'teacher' && $user->type === 'teacher') {
                return $next($request);
            }
            if ($role === 'student' && $user->type === 'student') {
                return $next($request);
            }
        }

        abort(403, 'Accès non autorisé.');
    }
    
}
