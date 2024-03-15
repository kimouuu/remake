<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NonMember\Dashboard\DashboardController;
use App\Http\Controllers\NonMember\User\UserController;
use App\Http\Controllers\NonMember\UserDocument\DocumentController;

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

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'can:role,"non-member"'], function () {
        Route::prefix('non-member')->as('non-member.')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('documents', DocumentController::class);
            Route::post('/register', [UserController::class, 'register'])->name('user.register');
        });
    });
});
