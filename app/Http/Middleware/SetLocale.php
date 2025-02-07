<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            $locale = session('locale');
        } else {
            $locale = config('app.locale', 'en');
        }

        Log::info('Current Session Data:', session()->all());
        Log::info("Setting locale to: $locale");

        App::setLocale($locale);

        return $next($request);
    }
}
