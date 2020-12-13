<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GameController;

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

Route::prefix('v1')->group(function(){
    Route::post("new_game", [GameController::class, 'newGame']);
    Route::post("try_game", [GameController::class, 'playGame']);
    Route::get("active_game_exists", [GameController::class, 'activeSessionGame']);
});
