<?php

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
            Route::get('/test', function () {
                return view('admin.test');
            });
        });
    });
});
