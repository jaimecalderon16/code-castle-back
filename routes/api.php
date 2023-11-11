<?php

use App\Http\Controllers\Api\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);


//buscar un usuario
Route::get('/users/{id}', [UserController::class, 'show']);

// Ruta para almacenar un nuevo usuario
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Ruta para obtener todos los usuarios
Route::get('/users', [UserController::class, 'index'])->name('users.index');
