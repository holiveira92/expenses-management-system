<?php

namespace App\Http\Controllers;

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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

/* Grupo de Rotas Não-Autenticadas */
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

/* Grupo de Rotas Autenticadas */
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'users' =>'UserController', // Rotas de Usuários
    ]);
});
