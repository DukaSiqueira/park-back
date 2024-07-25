<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventsLobbiesController;
use App\Http\Controllers\EventsLobbiesRecordsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('companies', [CompaniesController::class, 'index']);
    Route::get('events/{compId}', [EventsController::class, 'show']);
    Route::get('lobbies/{eventId}', [EventsLobbiesController::class, 'show']);
    Route::post('lobbies-records', [EventsLobbiesRecordsController::class, 'store']);
});
