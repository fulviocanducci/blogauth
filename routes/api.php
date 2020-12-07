<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\PeopleController;

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

Route::middleware([])->group(function () {
    Route::post('login', [LoginController::class, 'index']);
});


Route::middleware(['auth:api'])->group(function () {
    Route::get('people', [PeopleController::class, 'index']);
    Route::post('people', [PeopleController::class, 'create']);
    Route::get('people/{id}', [PeopleController::class, 'show'])->where('id', '[0-9]+');
    Route::put('people/{id}', [PeopleController::class, 'update'])->where('id', '[0-9]+');;
    Route::delete('people/{id}', [PeopleController::class, 'delete'])->where('id', '[0-9]+');;
});
