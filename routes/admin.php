<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\UserApproved\ApprovedUserController;
use App\Http\Controllers\Admin\DocumentApproved\ApprovedDocumentController;
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
            Route::resource('docs-approved', ApprovedDocumentController::class);
            Route::put('docs-approved/{id}', [ApprovedDocumentController::class, 'update'])->name('docs-approved.update');
            Route::resource('approved', ApprovedUserController::class);
            Route::put('approved/{id}', [ApprovedUserController::class, 'update'])->name('approved.update');
            Route::resource('profiles', ProfileController::class);
            Route::patch('profiles/{user}/password', [ProfileController::class, 'updatePassword'])->name('profiles.updatePassword');
        });
    });
});
