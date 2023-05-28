<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class FrontController extends Controller
{
    public function welcome($lang = null)
    {
        // dd('ok');
        
        return view('welcome');
    }
    
    public function changeLanguage($lang)
    {
        session(['frontLange' => $lang]);
        // dd(session()->all());
        App::setLocale($lang);
        
        return redirect()->back();
    }
}
