<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LocalizationController extends Controller
{
    public function changeLanguage($locale)
    {
        Log::info('Changing language to ' . $locale);
        
        // Validate locale
        if (!in_array($locale, ['en', 'km'])) {
            $locale = 'en';
        }
        
        // Set locale in session
        Session::put('locale', $locale);
        
        // Set locale for current request
        App::setLocale($locale);
        
        // Set cookie (60 days)
        $minutes = 60 * 24 * 60;
        Cookie::queue(Cookie::make('locale', $locale, $minutes));
        
        Log::info('Language changed', [
            'locale' => $locale,
            'session' => Session::get('locale'),
            'app_locale' => App::getLocale()
        ]);
        
        return redirect()->back();
    }
}
