<?php

namespace App\Http\Controllers;

use App\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ChatController extends Controller
{
    
    public function index()
    {
        return view('chat.index');
    }
    
    
    public function runcom()
    {
        $result = Artisan::call('npm run production');
        dd($result);
    }
}