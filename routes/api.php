<?php

use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\CategoryController;

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


//comments routes
//ver comentarios
Route::get('/comments/{id}', [CommentController::class,'index']);
//crear comentario
Route::post ('/comments-store',[CommentController::class,'store']);
//update
Route::put ('/comments/{id}',[CommentController::class,'update']);
//delete
Route::delete('/comments/{id}',[CommentController::class,'destroy']);


// // comments routes
// // ver comentarios
// Route::get('/comments', [CommentController::class, 'index']);
// // comentario por id
// Route::get('/comments/{id}', [CommentController::class, 'show']);
// // crear comentario
// Route::post('/comments-store', [CommentController::class, 'store']);
// // update
// Route::put('/comments/{id}', [CommentController::class, 'update']);
// // delete
// Route::delete('/comments/{id}', [CommentController::class, 'destroy']);


// routes/api.php
Route::get('/categories', [CategoryController::class, 'index']);  //lista de categorias


Route::prefix('apps')->group(function () {
    Route::get('/', [AppsController::class, 'index']);
    Route::get('/download/{id}', [AppsController::class, 'downloadSave']);
    Route::post('/search', [AppsController::class, 'search']);
    Route::get('/{id}', [AppsController::class, 'show']);
    Route::post('/create', [AppsController::class, 'store']);
    Route::put('/{id}', [AppsController::class, 'update']);
    Route::delete('/{id}', [AppsController::class, 'destroy']);
});
