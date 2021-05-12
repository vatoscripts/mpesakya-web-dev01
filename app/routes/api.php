<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', 'API\LoginController@login');

Route::post('auth/otp', 'API\LoginController@validateOTP');

Route::post('auth/reset-password', 'API\LoginController@resetPassword');

Route::post('auth/recover-password', 'API\LoginController@recoverPassword');

Route::post('auth/resend-otp', 'API\LoginController@resendOTP');

Route::post('auth/logout', 'API\LoginController@logoutUser')->name('logout');

/** AUTHENTICATION REQUIRED ROUTES */

Route::group(['middleware' => ['check-auth']], function () {
    Route::post('aggregator/onboard/first', 'API\AggregatorController@onboardAggregatorNIDA');

    Route::post('aggregator/onboard/second', 'API\AggregatorController@onboardAggregatorDB');

    Route::get('aggregator/all', 'API\AggregatorController@listAggregators');

    Route::post('wakala/onboard/first', 'API\WakalaController@onboardWakalaNIDA');

    Route::post('wakala/onboard/second', 'API\WakalaController@onboardWakalaDB');

    Route::get('wakala/all', 'API\WakalaController@listWakala');

    Route::post('wakala/onboard/recruiter', 'API\WakalaController@onboardWakalaRecruiter');

    Route::post('wakala/onboard/getcontractOTP', 'API\WakalaController@getContractOTPCode');
    Route::post('wakala/onboard/verify-contractOTP', 'API\WakalaController@verifyContractOTPCode');

    Route::get('wakala/unverified', 'API\WakalaController@getUnverifiedWakala');

    Route::post('wakala/unverified', 'API\WakalaController@viewUnverifiedWakala');

    Route::post('wakala/verify', 'API\WakalaController@verifyWakala');

    Route::get('wakala/approved', 'API\WakalaController@getApprovedWakala');

    Route::get('wakala/rejected', 'API\WakalaController@getDeclinedWakala');

    Route::get('wakala/verification-status', 'API\WakalaController@getWakalaListWithStatus');


    Route::get('/zone', 'API\AggregatorController@getZones')->name('agent.zones');
    Route::get('/region/{Id}', 'API\AggregatorController@getRegions')->name('agent.regions');
    Route::get('/territory/{Id}', 'API\AggregatorController@getTerritory')->name('agent.territory');

    /**
     * REPORTS
     */
    Route::post('reports', 'API\ReportController@registrationReport')->name('api.reg-reports');
    Route::get('reports/categories', 'API\ReportController@getRegistrationReportCategories')->name('api.reg-reports.categories');
});
