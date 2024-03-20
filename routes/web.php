<?php

use App\Http\Controllers\Dashboard\KebunController;
use App\Http\Controllers\Dashboard\RekapController;
use App\Http\Controllers\DashboardCetakDataController;
use App\Http\Controllers\DashboardFormCetakController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardTanamanController;
use App\Http\Controllers\DashboardOverviewController;
use App\Http\Controllers\DashboardProduksiController;
use App\Http\Controllers\DashboardKecamatanController;
use App\Http\Controllers\DashboardTahunPanenController;
use App\Http\Controllers\DashboardKlasifikasiTanamanController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('kecamatan.index');
    } else {
        return redirect()->route('login.index');
    }
});

Route::get('/home', function () {
    if (auth()->check()) {
        return redirect()->route('kecamatan.index');
    } else {
        return redirect()->route('login.index');
    }
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});


Route::middleware('auth')->group(function () {
    Route::group(['prefix' => '/dashboard/data'], function () {
        Route::resource('/kebun', KebunController::class)->except([
            'create', 'show', 'edit'
        ]);
        Route::resource('/rekap', RekapController::class)->except([
            'create', 'show', 'edit'
        ]);
    });

    Route::group(['prefix' => '/dashboard/form-cetak'], function () {
        Route::get('/rekap', [DashboardFormCetakController::class, 'formCetakRekap'])->name('formCetakRekap');
    });

    Route::group(['prefix' => '/dashboard/cetak-data'], function () {
        Route::get('/cetak-kebun', [DashboardCetakDataController::class, 'cetakKebun'])->name('cetakKebun');
        Route::get('/cetak-rekap/{start_date}/{end_date}', [DashboardCetakDataController::class, 'cetakRekap'])->name('cetakRekap');
    });
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
