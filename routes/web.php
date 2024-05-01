<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PelakuController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermintaanController;
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
Route::get('/user/logout', [AuthController::class, 'logout']);
Route::get('/pelaku/login', [AuthController::class, 'pelakuLogin']);
Route::POST('/login', [AuthController::class, 'authenticate']);

Route::get('/', [DashboardController::class, 'index'])->middleware(['both']);
Route::resource('/obat', ObatController::class)->middleware(['both']);
Route::get('/obat/hapus/{id}', [ObatController::class, 'delete'])->middleware(['admin']);
Route::resource('/satuan', SatuanController::class)->middleware(['admin']);
Route::get('/satuan/hapus/{id}', [SatuanController::class, 'delete'])->middleware(['admin']);
Route::resource('/user-admin', AdminUserController::class)->middleware(['admin']);
Route::get('/user-admin/hapus/{id}', [AdminUserController::class, 'delete'])->middleware(['admin']);
Route::resource('/pelaku', PelakuController::class)->middleware(['admin']);
Route::get('/pelaku/hapus/{id}', [PelakuController::class, 'delete'])->middleware(['admin']);
Route::resource('/batch', BatchController::class)->middleware(['both']);
Route::resource('/stok-opname', StokOpnameController::class)->middleware(['admin']);
Route::get('/batch/hapus/{id}', [BatchController::class, 'delete'])->middleware(['admin']);
Route::get('/website-setting', [HomeController::class, 'websiteSetting'])->middleware(['admin']);
Route::post('/home/setting-save', [HomeController::class, 'simpansetting'])->middleware(['admin']);
Route::get('/stok-log', [HomeController::class, 'stokLog'])->middleware(['both']);


Route::get('/lakukan-permintaan', [PermintaanController::class, 'index'])->middleware(['pelaku']);
Route::post('/lakukan-permintaan', [PermintaanController::class, 'store'])->middleware(['pelaku']);
Route::get('/detail-permintaan/{id}', [PermintaanController::class, 'detail'])->middleware(['both']);

Route::get('/permintaan-obat', [PermintaanController::class, 'permintaanObat'])->middleware(['both']);
Route::get('/permintaan-obat/{id}', [PermintaanController::class, 'tindakLanjutPermintaan'])->middleware(['both']);

Route::post('/permintaan-obat/tindak-lanjut', [PermintaanController::class, 'tindakLanjut'])->middleware(['admin']);
Route::get('/export-stok-opname', [ExportController::class, 'exportStokOpname'])->middleware(['admin']);
Route::get('/export-dau', [ExportController::class, 'exportDau'])->middleware(['admin']);
Route::get('/export-dak', [ExportController::class, 'exportDak'])->middleware(['admin']);
Route::get('/export-program', [ExportController::class, 'exportProgram'])->middleware(['admin']);
