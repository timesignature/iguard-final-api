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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:security-api')->get('/admin', function (Request $request) {
    return $request->user();
});



Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'add']);

Route::get('/companies',[\App\Http\Controllers\SecurityController::class,'get']);
Route::middleware(['auth:api'])->get('/company/{id}',[\App\Http\Controllers\SecurityController::class,'getOne']);
Route::middleware(['auth:api'])->post('/company/{id}',[\App\Http\Controllers\SecurityController::class,'update']);





Route::post('/security-login',[\App\Http\Controllers\SecurityController::class,'login']);
Route::post('/security-register',[\App\Http\Controllers\SecurityController::class,'create']);
Route::post('/security-password-reset',[\App\Http\Controllers\SecurityController::class,'reset_password']);


Route::middleware(['auth:gd-api'])->get('/sites',[\App\Http\Controllers\SiteController::class,'getForGuard']);
Route::middleware(['auth:security-api'])->get('/security-sites',[\App\Http\Controllers\SiteController::class,'get']);
Route::middleware(['auth:security-api'])->get('/site/{id}',[\App\Http\Controllers\SiteController::class,'getOne']);
Route::middleware(['auth:security-api'])->get('/sites-grouped',[\App\Http\Controllers\SiteController::class,'grouped']);
Route::middleware(['auth:security-api'])->post('/sites',[\App\Http\Controllers\SiteController::class,'add']);

Route::post('/guards-login',[\App\Http\Controllers\GdController::class,'login']);
Route::middleware('auth:security-api')->post('/guards',[\App\Http\Controllers\GdController::class,'add']);
Route::middleware(['auth:security-api'])->get('/guards',[\App\Http\Controllers\GdController::class,'get']);


Route::post('/clients-login',[\App\Http\Controllers\ClientController::class,'login']);
Route::middleware(['auth:security-api'])->post('/clients',[\App\Http\Controllers\ClientController::class,'add']);
Route::middleware(['auth:security-api'])->get('/clients',[\App\Http\Controllers\ClientController::class,'get']);

Route::get('/mail-send',function(){
    \Illuminate\Support\Facades\Mail::to('eguard789@gmail.com')->send(new \App\Mail\TextMail());
    return 'email sent';

});




Route::get('/shifts',[\App\Http\Controllers\ShiftController::class,'get']);

Route::middleware(['auth:gd-api'])->post('/shifts',[\App\Http\Controllers\ShiftController::class,'add']);
Route::middleware(['auth:gd-api'])->get('/shift',[\App\Http\Controllers\ShiftController::class,'getLast']);
Route::middleware(['auth:gd-api'])->get('/shift-end/{id}',[\App\Http\Controllers\ShiftController::class,'end']);

Route::middleware(['auth:security-api'])->get('/security-shifts',[\App\Http\Controllers\ShiftController::class,'get']);
Route::middleware(['auth:security-api'])->get('/security-shift/{id}',[\App\Http\Controllers\ShiftController::class,'getById']);

Route::middleware(['auth:gd-api'])
    ->post('/patrols',[\App\Http\Controllers\PatrolController::class,'add']);

Route::middleware(['auth:security-api'])->get('/patrol/{id}',[\App\Http\Controllers\PatrolController::class,'get']);


Route::middleware(['auth:gd-api'])->post('/report',[\App\Http\Controllers\ReportController::class,'add']);
Route::middleware(['auth:security-api'])->get('/report/{id}',[\App\Http\Controllers\ReportController::class,'get']);


Route::middleware(['auth:gd-api'])->post('/point',[\App\Http\Controllers\PointController::class,'add']);
Route::get('/point',[\App\Http\Controllers\PointController::class,'get']);
