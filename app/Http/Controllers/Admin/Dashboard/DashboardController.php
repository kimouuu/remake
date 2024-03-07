<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = Setting::firstorFail();
        return view('admin.dashboard.index', compact('setting'));
    }
}
