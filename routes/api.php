<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WriterController;
use App\Http\Controllers\Api\BookController; 


// API routes for authentication
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//api routes User for perfil 
Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);


});

// API routes for writers
Route::middleware('auth:api')->group(function(){
    Route::get('/writers', [WriterController::class, 'index']);
    Route::get('/writers/{id}',[WriterController::class, 'show']);
    Route::post('/writers', [WriterController::class, 'store']);
    Route::put('/writers/{id}', [WriterController::class, 'update']);
    Route::delete('/writers/{id}', [WriterController::class, 'destroy']);

});

// API routes for Book
Route::get('/books',[BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/filter', [BookController::class, 'filterGeners']); // Nueva ruta para filtrar

Route::middleware('auth:api')->group(function(){
    Route::post('/book',[BookController::class, 'store']);
    Route::put('/book/{id}', [BookController::class, 'update']);
    Route::delete('/book/{id}', [BookController::class, 'destroy']);



});

