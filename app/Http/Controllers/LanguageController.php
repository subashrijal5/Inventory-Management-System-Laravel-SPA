<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change the application language
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|in:en,ne'
        ]);

        $locale = $request->input('locale');
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store the locale in session
        Session::put('locale', $locale);
        
        return \redirect()->back();
    }
}