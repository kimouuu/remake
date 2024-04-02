<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\Document\UserDocumentController;
use App\Http\Controllers\Member\Dashboard\DashboardController;
use App\Http\Controllers\Member\Profile\ProfileController;
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
    Route::group(['middleware' => 'can:role,"member","non-member","user"'], function () {
        Route::prefix('member')->as('member.')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('documents', UserDocumentController::class);
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/register', [DashboardController::class, 'register'])->name('dashboard.register');
            Route::resource('profiles', ProfileController::class);
            Route::patch('profiles/{user}/password', [ProfileController::class, 'updatePassword'])->name('profiles.updatePassword');
        });
    });
});
