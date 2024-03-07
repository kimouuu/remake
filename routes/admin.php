<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\UserDocumentType\DocumentTypeController;
use Illuminate\Support\Facades\Route;

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
    Route::group(['middleware' => 'can:role,"admin"'], function () {
        Route::prefix('admin')->as('admin.')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('events', EventController::class);
            Route::resource('settings', SettingController::class);
            Route::resource('news', NewsController::class);
            Route::resource('document-types', DocumentTypeController::class);
            Route::resource('profiles', ProfileController::class);
            Route::patch('profiles/{user}/password', [ProfileController::class, 'updatePassword'])->name('profiles.updatePassword');
        });
    });
});
