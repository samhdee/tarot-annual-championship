<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PastHandsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

//Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(HomeController::class)
        ->prefix('/')
        ->group(function () {
            Route::get('/', 'index')->name('home');
        });

    Route::controller(PastHandsController::class)
        ->prefix('hand')
        ->group(function () {
            Route::get('index', 'index')->name('past_hands_index');
            Route::get('add', 'add')->name('hand_add');
        });

    Route::controller(GameController::class)
        ->prefix('game')
        ->group(function () {});

    Route::controller(UserProfileController::class)
        ->prefix('user')
        ->group(function () {
            Route::get('/', 'index')->name('user_profile_index');
        });

    Route::controller(AdminController::class)
        ->prefix('admin')
        ->group(function () {
            Route::get('/', 'index')->name('admin_index');
        });
//});
