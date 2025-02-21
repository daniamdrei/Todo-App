<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\auth;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\TodoController::class, 'index'])->middleware(['auth','verified'])->name('home');

Route::middleware(['auth' , 'verified'])->group(function(){
    Route::patch('/todos/{todo}/toggle' , [TodoController::class,'toggleCompleted'])->name('todos.toggleCompleted');
    Route::get('/todos/trashed' , [TodoController::class,'trashed'])->name('todos.trashed');
    Route::get('/todos/{id}/restore' , [TodoController::class,'restore'])->name('todos.restore');
    Route::delete('/todos/{id}/force-delete' , [TodoController::class,'forceDelete'])->name('todos.forceDelete');
    Route::delete('/todos/clearall', [TodoController::class, 'clearAll'])->name('todos.clearall');
    Route::delete('/todos/clearTrash', [TodoController::class, 'clearTrash'])->name('todos.cleartrash');
});
Route::resource('todos', TodoController::class)->middleware(['auth','verified']);

