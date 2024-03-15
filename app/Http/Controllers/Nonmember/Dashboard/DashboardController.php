<?php

namespace App\Http\Controllers\Nonmember\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserDocumentType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $types = UserDocumentType::all();
        return view('non-member.dashboard.index', compact('types'));
    }
}
