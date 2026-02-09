<?php

use App\Http\Controllers\Admin\AdminHandsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::controller(HistoryController::class)
    ->prefix('/history')
    ->group(function () {
        Route::get('/', 'index')->name('history');
        Route::get('/sort/{direction}', 'sort')
            ->name('hand_sort')
            ->where('direction', 'asc|desc');
    });

Route::controller(GameController::class)
    ->prefix('game')
    ->group(function () {});

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::controller(HistoryController::class)
        ->prefix('hand')
        ->group(function () {
            Route::get('add', 'add')->name('hand_add');
        });

    Route::controller(UserProfileController::class)
        ->prefix('user')
        ->group(function () {
            Route::get('/', 'index')->name('user_profile_index');
        });

    Route::middleware(['admin'])
        ->prefix('admin')
        ->group(function () {
            Route::controller(AdminUsersController::class)->group(function () {
                Route::get('/users', 'index')->name('admin_users');
                Route::get('/user/{user_id}/toggleActive/{new_state}', 'switchActive')
                    ->name('admin_users_active');
                Route::get('/user/{bga_user_id}/toggleAdmin/{new_state}', 'switchAdmin')
                    ->name('admin_users_admin');
            });

            Route::controller(AdminHandsController::class)
                ->prefix('hands')
                ->group(function () {
                    Route::get('/', 'index')->name('admin_hands');
                    Route::get('/hand/{hand_id}/delete', 'delete')->name('admin_hands_delete');
                });
        });
});
