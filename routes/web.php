<?php

use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', [LoginController::class, 'dashboard']);
Route::get('/dashboard', [LoginController::class, 'dashboard']);
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/barang', [BarangController::class, 'index']);
Route::post('/tambahBarang', [BarangController::class, 'store']);
Route::post('/editBarang', [BarangController::class, 'update']);
Route::post('/hapusBarang/{barang:id}', [BarangController::class, 'destroy']);

Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::post('/tambahPenjualan', [PenjualanController::class, 'store']);
Route::post('/editPenjualan', [PenjualanController::class, 'update']);
Route::post('/hapusPenjualan/{penjualan:id}', [PenjualanController::class, 'destroy']);
