<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;



Route::get('/', [TodoController::class, 'index']);
Route::post('/store', [TodoController::class, 'store']);
Route::patch('/complete/{id}', [TodoController::class, 'toggleComplete']);
Route::patch('/edit/{id}', [TodoController::class, 'update']);
Route::delete('/delete/{id}', [TodoController::class, 'destroy']);
