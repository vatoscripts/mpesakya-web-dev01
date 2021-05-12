<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** AUTHENTICATION ROUTES */
Route::get('/', 'AppController@index' )->name('login');
Route::get('/login', 'AppController@index' )->name('login');
Route::get('otp', 'AppController@otp' )->name('otp');
Route::get('forgot-password', 'AppController@resetPassword' )->name('otp');
Route::get('recover-password', 'AppController@recoverPassword' )->name('otp');
Route::get('user/logout', 'AppController@logoutUser')->name('logout');

Route::group(['middleware' => ['check-auth']], function () {
    /** HOME ROUTEs */
    Route::get('home', 'AppController@home')->name('home');

    /** OTHER ROUTES */
    Route::get('/{any?}', 'AppController@home')->where('any', '.*');
});
