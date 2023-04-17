<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('home');
Route::get('about', [TodoController::class, 'about'])->name('about');

Route::get('tasks',[TaskController::class, 'index'])->name('tasks');
Route::post('tasks',[TaskController::class, 'store'])->name('tasks.store');
Route::put('tasks/{task}',[TaskController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{task}',[TaskController::class, 'destroy'])->name('tasks.destroy');