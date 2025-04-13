<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index']);
Route::post('/store', [TodoController::class, 'store']);
Route::get('/edit/{todo}', [TodoController::class, 'edit']);
Route::patch('/edit/{todo}', [TodoController::class, 'update']);
Route::delete('/delete/{todo}', [TodoController::class, 'destroy']);
Route::patch('/toggle-complete/{id}', [TodoController::class, 'toggleComplete'])->name('toggle.complete');
