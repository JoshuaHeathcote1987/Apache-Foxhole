<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\SoldierController;


Route::get('/', function () { return view('welcome'); })->name('welcome');

Route::middleware(['auth'])->group(function () 
{
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/todo', function () { return view('todo'); })->name('todo');

    Route::resources([
        'news' => NewsController::class,
        'orders' => OrderController::class,
        'join' => JoinController::class,
        'vote' => VoteController::class,
    ]);
});

require __DIR__.'/auth.php';