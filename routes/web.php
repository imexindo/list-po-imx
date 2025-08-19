<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasangBaruController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'permission:dashboard_access'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['permission:pasang_baru_access'])->prefix('pasang-baru')->group(function () {
        Route::get('/', [PasangBaruController::class, 'index'])->name('pasang-baru.index');
        Route::get('/get-spk', [PasangBaruController::class, 'getSpk'])->name('getSpk');
    });
    Route::middleware(['permission:roles_access'])->prefix('roles')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexRoles'])->name('roles.index');
        Route::post('/store', [RolePermissionController::class, 'storeRole'])->name('roles.store');
        Route::put('/update/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
        Route::delete('/destroy/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
        Route::get('/{role}/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('roles.getPermissions');
    });

    Route::middleware(['permission:permissions_access'])->prefix('permissions')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexPermissions'])->name('permissions.index');
        Route::post('/store', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
        Route::put('/update/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/destroy/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
    });

    Route::middleware(['permission:users_access'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    });


});

require __DIR__.'/auth.php';
