<?php

namespace App\Http\Controllers\Auth\Forgot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        return view('auth.forgot.forgot');
    }
}
