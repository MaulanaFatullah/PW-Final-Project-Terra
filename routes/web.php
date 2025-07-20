<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\user\MenuUserController;
use App\Http\Controllers\user\OrderUserController;
use App\Http\Controllers\user\ReservationUserController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\waiter\OrderWaiterController;
use App\Http\Controllers\waiter\WaiterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/reservation_landing', [LandingController::class, 'store'])->name('reservation_landing.store');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('menus', MenuController::class);
    Route::resource('reservations', ReservationController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'role.waiter'])->group(function () {
    Route::get('/waiter', [WaiterController::class, 'index'])->name('waiter.dashboard');

    Route::resource('orders-waiter', OrderWaiterController::class)->only(['index', 'show', 'update']);
});