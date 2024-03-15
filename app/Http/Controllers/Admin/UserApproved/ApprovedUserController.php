<?php

namespace App\Http\Controllers\Admin\UserApproved;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovedUserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'process')->get();
        return view('admin.user-approved.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = 'active';
        $user->role = 'member';
        $user->save();
        return redirect()->back()->with('success', 'User Approved Successfully');
    }
}
