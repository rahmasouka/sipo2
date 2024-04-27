<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PelakuController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StokOpnameController;
use Illuminate\Support\Facades\Route;

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

Route::get('/user/login', [AuthController::class, 'userLogin']);
Route::POST('/login', [AuthController::class, 'authenticate']);

Route::get('/', [DashboardController::class, 'index']);
Route::resource('/obat', ObatController::class);
Route::get('/obat/hapus/{id}', [ObatController::class, 'delete']);
Route::resource('/satuan', SatuanController::class);
Route::get('/satuan/hapus/{id}', [SatuanController::class, 'delete']);
Route::resource('/user-admin', AdminUserController::class);
Route::get('/user-admin/hapus/{id}', [AdminUserController::class, 'delete']);
Route::resource('/pelaku', PelakuController::class);
Route::get('/pelaku/hapus/{id}', [PelakuController::class, 'delete']);
Route::resource('/batch', BatchController::class);
Route::resource('/stok-opname', StokOpnameController::class);
Route::get('/batch/hapus/{id}', [BatchController::class, 'delete']);
Route::get('/website-setting', [HomeController::class, 'websiteSetting']);
Route::post('/home/setting-save', [HomeController::class, 'simpansetting']);
