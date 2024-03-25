<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Auth\Otp\OtpValidationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Auth::routes(['verify' => true]);
Route::middleware('guest')->group(function () {
    //Login
    Route::get('login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('login', [LoginController::class, 'handleLogin'])->name('login');

    //Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('register/verification/{userId}', [OtpValidationController::class, 'index'])->name('register.verificationOtp.index');
Route::get('register/verification/{userId}/show', [OtpValidationController::class, 'show'])->name('register.verificationOtp.show');
Route::post('register/resend/{userId}', [OtpValidationController::class, 'resendOtpCode'])->name('register.verificationOtp.resendOtpCode');
Route::post('register/verification/{userId}', [OtpValidationController::class, 'verification'])->name('register.verificationOtp.verification');
Route::get('register/verification/{userId}/update', [OtpValidationController::class, 'update'])->name('register.verificationOtp.update');
Route::post('register/verification/{userId}/verified', [OtpValidationController::class, 'verified'])->name('register.verificationOtp.verified');
Route::get('register/verification/{userId}/verified-mail-otp', [OtpValidationController::class, 'indexVerifiedMailOtp'])->name('register.verificationMailOtp.index');
Route::post('register/verification/{userId}/verified-mail-otp', [OtpValidationController::class, 'verifyEmail'])->name('verify.email');
Route::post('register/verification/{userId}/verified-mail-otp/resend', [OtpValidationController::class, 'resendEmailOtp'])->name('resend.email.verification');
