<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function switchLang(Request $request)
    {
        Log::info('Language switch attempted', ['requested_lang' => $request->input('lang')]);
        
        $lang = $request->input('lang', 'en');
        
        if (!in_array($lang, ['en', 'km'])) {
            $lang = 'en';
        }
        
        Session::put('locale', $lang);
        App::setLocale($lang);
        
        // Store in cookie for persistence
        Cookie::queue('locale', $lang, 60 * 24 * 30); // 30 days
        
        Log::info('Language switched', [
            'lang' => $lang,
            'session_locale' => Session::get('locale'),
            'app_locale' => App::getLocale()
        ]);
        
        return redirect()->back();
    }
} 