<?php

use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::post('/register', [PassportAuthController::class, 'register'])->name('api.register'); // Crea usuario
Route::post('/login', [PassportAuthController::class, 'login'])->name('api.login');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [PassportAuthController::class, 'authenticatedUser'])->name('api.passport_auth.authenticatedUser'); // Devuelve usuario logueado

    Route::post('/logout', [PassportAuthController::class, 'logout'])->name('api.logout');

    //Route::post('/players', [PlayerController::class, 'store'])->name('api.player.store'); === REGISTER -> /register
    Route::get('/players', [PlayerController::class, 'index'])->name('api.player.index'); // Muestra usuario/s de la bbdd
    Route::put('/players', [PlayerController::class, 'update'])->name('api.player.update'); // Actualiza nombre usuario

    Route::post('/players/games', [PlayerController::class, 'storeGame'])->name('api.player.store_game'); // Crea una tirada del usuario logueado
    Route::delete('/players/games', [PlayerController::class, 'destroyGame'])->name('api.player.destroy_game'); // Elimina todas las tiradas del usuario logueado
    Route::get('/players/games', [PlayerController::class, 'showGame'])->name('api.player.show_game'); // Muestra todas las tiradas del usuario logueado

    Route::get('/players/ranking', [PlayerController::class, 'ranking'])->name('api.player.ranking');
    Route::get('/players/ranking/loser', [PlayerController::class, 'rankingLoser'])->name('api.player.rankingLoser');
    Route::get('/players/ranking/winner', [PlayerController::class, 'rankingWinner'])->name('api.player.rankingWinner');
});

