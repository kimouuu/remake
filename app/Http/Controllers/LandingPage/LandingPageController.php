<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrFail();
        return view('welcome', compact('setting'));
    }
}
