<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Country;

class CityController extends Controller
{
    public function index()
    {
        return Country::all();
    }
}
