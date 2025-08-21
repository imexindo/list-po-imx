<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DcController;
use App\Http\Controllers\extSementaraController;
use App\Http\Controllers\InputSpkController;
use App\Http\Controllers\PasangBaruController;
use App\Http\Controllers\PutusController;
use App\Http\Controllers\RelokasiController;

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

    Route::middleware(['permission:input_spk_access'])->prefix('input-spk')->group(function () {
        Route::get('/', [InputSpkController::class, 'index'])->name('input-spk.index');
        // Route::get('/spk-search', [InputSpkController::class, 'searchSpk'])->name('search-spk');
        Route::get('/search-spk', [InputSpkController::class, 'searchSpk'])->name('searchSpk');
        Route::get('/verify-spk', [InputSpkController::class, 'getSpk'])->name('verifySpk');
        Route::post('/input-spk/store', [InputSpkController::class, 'store'])->name('spkStore');
    });


    Route::middleware(['permission:pasang_baru_access'])->prefix('pasang-baru')->group(function () {
        Route::get('/', [PasangBaruController::class, 'index'])->name('pasang-baru.index');
        Route::get('/get', [PasangBaruController::class, 'getPO'])->name('pasang-baru.get');
        Route::get('/get/edit/{id}', [PasangBaruController::class, 'getPOById'])->name('pasang-baru.getById');
        Route::put('/get/update/{id}', [PasangBaruController::class, 'update'])->name('pasang-baru.update');
    });

    Route::middleware(['permission:dc_access'])->prefix('dc')->group(function () {
        Route::get('/', [DcController::class, 'index'])->name('dc.index');
        Route::get('/get', [DcController::class, 'getPO'])->name('dc.get');
        Route::get('/get/edit/{id}', [DcController::class, 'getPOById'])->name('dc.getById');
        Route::put('/get/update/{id}', [DcController::class, 'update'])->name('dc.update');
    });

    Route::middleware(['permission:relokasi_access'])->prefix('relokasi')->group(function () {
        Route::get('/', [RelokasiController::class, 'index'])->name('relokasi.index');
        Route::get('/get', [RelokasiController::class, 'getPO'])->name('relokasi.get');
        Route::get('/get/edit/{id}', [RelokasiController::class, 'getPOById'])->name('relokasi.getById');
        Route::put('/get/update/{id}', [RelokasiController::class, 'update'])->name('relokasi.update');
    });


    Route::middleware(['permission:extSementara_access'])->prefix('extSementara')->group(function () {
        Route::get('/', [extSementaraController::class, 'index'])->name('extSementara.index');
        Route::get('/get', [extSementaraController::class, 'getPO'])->name('extSementara.get');
        Route::get('/get/edit/{id}', [extSementaraController::class, 'getPOById'])->name('extSementara.getById');
        Route::put('/get/update/{id}', [extSementaraController::class, 'update'])->name('extSementara.update');
    });


    Route::middleware(['permission:putus_access'])->prefix('putus')->group(function () {
        Route::get('/', [PutusController::class, 'index'])->name('putus.index');
        Route::get('/get', [PutusController::class, 'getPO'])->name('putus.get');
        Route::get('/get/edit/{id}', [PutusController::class, 'getPOById'])->name('putus.getById');
        Route::put('/get/update/{id}', [PutusController::class, 'update'])->name('putus.update');
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
