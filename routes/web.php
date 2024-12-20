<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// dashboard
Route::get('admin', [AdminController::class, 'index'])->name('admin');


// pendaftar
Route::get('admin/pendaftar', [AdminController::class, 'pendaftar'])->name('pendaftar');
Route::get('admin/pendaftar/tambah', [AdminController::class, 'tambahpendaftar'])->name('tambahpendaftar');
Route::get('admin/pendaftar/detail', [AdminController::class, 'detailpendaftar'])->name('detailpendaftar');


// akun
Route::get('admin/akun', [AdminController::class, 'akun'])->name('akun');
Route::get('admin/akun/tambah', [AdminController::class, 'tambahakun'])->name('tambahakun');
Route::post('admin/akun/tambah', [AdminController::class, 'postakun'])->name('postakun');
Route::get('admin/akun/edit/{id}', [AdminController::class, 'editakun'])->name('editakun');
Route::delete('admin/akun/hapus/{id}', [AdminController::class, 'hapusakun'])->name('hapusakun');
Route::get('admin/akun/detail', [AdminController::class, 'detailakun'])->name('detailakun');


// asdos
Route::get('admin/asdos', [AdminController::class, 'asdos'])->name('asdos');
Route::get('admin/asdos/tambah', [AdminController::class, 'tambahasdos'])->name('tambahasdos');
Route::get('admin/asdos/detail', [AdminController::class, 'detailasdos'])->name('detailasdos');


// dosen
Route::get('admin/dosen', [AdminController::class, 'dosen'])->name('dosen');
Route::get('admin/dosen/tambah', [AdminController::class, 'tambahdosen'])->name('tambahdosen');
Route::get('admin/dosen/detail', [AdminController::class, 'detaildosen'])->name('detaildosen');


// matkul
Route::get('admin/matkul', [AdminController::class, 'matkul'])->name('matkul');
Route::get('admin/matkul/tambah', [AdminController::class, 'tambahmatkul'])->name('tambahmatkul');
Route::get('admin/matkul/detail', [AdminController::class, 'detailmatkul'])->name('detailmatkul');


// periode
Route::get('admin/periode', [AdminController::class, 'periode'])->name('periode');
Route::get('admin/periode/tambah', [AdminController::class, 'tambahperiode'])->name('tambahperiode');
Route::get('admin/periode/detail', [AdminController::class, 'detailperiode'])->name('detailperiode');
