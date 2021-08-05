<?php

use App\Http\Controllers\Api\{
    ClosedTicketsController,
    OpenTicketsController,
    StatsController,
    UserTicketsController
};

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('open-tickets', OpenTicketsController::class);
    Route::get('closed-tickets', ClosedTicketsController::class);
    Route::get('users/{email}/tickets', UserTicketsController::class);
    Route::get('stats', StatsController::class);
});
