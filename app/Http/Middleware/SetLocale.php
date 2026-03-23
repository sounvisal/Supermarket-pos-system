<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Default locale
            $locale = 'en';
            
            // Check session first (most reliable)
            if (Session::has('locale')) {
                $locale = Session::get('locale');
            }
            // Then check cookie
            elseif ($request->cookie('locale')) {
                $locale = $request->cookie('locale');
                Session::put('locale', $locale);
            }
            
            // Make sure locale is valid
            if (!in_array($locale, ['en', 'km'])) {
                $locale = 'en';
                Session::put('locale', $locale);
            }
            
            // Set the locale
            App::setLocale($locale);
            
            // Log for debugging
            Log::info('SetLocale middleware running', [
                'session_locale' => Session::get('locale'),
                'cookie_locale' => $request->cookie('locale'),
                'final_locale' => $locale,
                'app_locale' => App::getLocale(),
                'url' => $request->fullUrl()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in SetLocale middleware: ' . $e->getMessage());
            // Default to English on error
            App::setLocale('en');
        }
        
        return $next($request);
    }
}
