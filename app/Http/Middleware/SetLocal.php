<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale', config('app.locale'));
        
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            $request->session()->put('locale', $locale);
        }
        
        if (!array_key_exists($locale, config('app.available_locales'))) {
            $locale = config('app.fallback_locale');
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}
