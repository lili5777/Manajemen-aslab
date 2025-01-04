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
Route::get('admin/pendaftar/detail/{id}', [AdminController::class, 'detailpendaftar'])->name('detailpendaftar');
Route::get('admin/pendaftar/edit/{id}', [AdminController::class, 'editpendaftar'])->name('editpendaftar');
Route::post('admin/pendaftar/tambah', [AdminController::class, 'postpendaftar'])->name('postpendaftar');
Route::delete('admin/pendaftar/hapus/{id}', [AdminController::class, 'hapuspendaftar'])->name('hapuspendaftar');


//transkip 
Route::get('admin/pendaftar/transkip/{id}', [AdminController::class, 'transkip'])->name('transkip');
Route::get('admin/pendaftar/transkip/tambah/{id}', [AdminController::class, 'tambahtranskip'])->name('tambahtranskip');
Route::post('admin/pendaftar/transkip/tambah', [AdminController::class, 'posttranskip'])->name('posttranskip');
Route::delete('admin/pendaftar/transkip/hapus/{id}', [AdminController::class, 'hapustranskip'])->name('hapustranskip');

// akun
Route::get('admin/akun', [AdminController::class, 'akun'])->name('akun');
Route::get('admin/akun/tambah', [AdminController::class, 'tambahakun'])->name('tambahakun');
Route::post('admin/akun/tambah', [AdminController::class, 'postakun'])->name('postakun');
Route::get('admin/akun/edit/{id}', [AdminController::class, 'editakun'])->name('editakun');
Route::delete('admin/akun/hapus/{id}', [AdminController::class, 'hapusakun'])->name('hapusakun');
Route::get('admin/akun/detail/{id}', [AdminController::class, 'detailakun'])->name('detailakun');


// asdos
Route::get('admin/asdos', [AdminController::class, 'asdos'])->name('asdos');
Route::get('admin/asdos/tambah', [AdminController::class, 'tambahasdos'])->name('tambahasdos');
Route::get('admin/asdos/detail', [AdminController::class, 'detailasdos'])->name('detailasdos');


// dosen
Route::get('admin/dosen', [AdminController::class, 'dosen'])->name('dosen');
Route::get('admin/dosen/tambah', [AdminController::class, 'tambahdosen'])->name('tambahdosen');
Route::post('admin/dosen/tambah', [AdminController::class, 'postdosen'])->name('postdosen');
Route::get('admin/dosen/detail/{id}', [AdminController::class, 'detaildosen'])->name('detaildosen');
Route::get('admin/dosen/edit/{id}', [AdminController::class, 'editdosen'])->name('editdosen');
Route::delete('admin/dosen/hapus/{id}', [AdminController::class, 'hapusdosen'])->name('hapusdosen');


// matkul
Route::get('admin/matkul', [AdminController::class, 'matkul'])->name('matkul');
Route::get('admin/matkul/tambah', [AdminController::class, 'tambahmatkul'])->name('tambahmatkul');
Route::get('admin/matkul/detail/{id}', [AdminController::class, 'detailmatkul'])->name('detailmatkul');
Route::post('admin/matkul/tambah', [AdminController::class, 'postmatkul'])->name('postmatkul');
Route::get('admin/matkul/edit/{id}', [AdminController::class, 'editmatkul'])->name('editmatkul');
Route::delete('admin/matkul/hapus/{id}', [AdminController::class, 'hapusmatkul'])->name('hapusmatkul');


// periode
Route::get('admin/periode', [AdminController::class, 'periode'])->name('periode');
Route::get('admin/periode/tambah', [AdminController::class, 'tambahperiode'])->name('tambahperiode');
Route::post('admin/periode/tambah', [AdminController::class, 'postperiode'])->name('postperiode');
Route::get('admin/periode/edit/{id}', [AdminController::class, 'editperiode'])->name('editperiode');
Route::post('admin/periode/update', [AdminController::class, 'updateperiode'])->name('updateperiode');
Route::get('admin/periode/detail/{id}', [AdminController::class, 'detailperiode'])->name('detailperiode');
Route::delete('admin/periode/hapus/{id}', [AdminController::class, 'hapusperiode'])->name('hapusperiode');


// jadwal
Route::get('admin/jadwal', [AdminController::class, 'jadwal'])->name('jadwal');
Route::get('admin/jadwal/tambah', [AdminController::class, 'tambahjadwal'])->name('tambahjadwal');
Route::post('admin/jadwal/tambah', [AdminController::class, 'postjadwal'])->name('postjadwal');
Route::delete('admin/jadwal/hapus/{id}', [AdminController::class, 'hapusjadwal'])->name('hapusjadwal');
Route::get('admin/jadwal/edit/{id}', [AdminController::class, 'editjadwal'])->name('editjadwal');


// pilihan matkul prakter
Route::get('admin/pilmatkul/{id}', [AdminController::class, 'pilmatkul'])->name('pilmatkul');
Route::get('admin/pilmatkul/tambah/{id}', [AdminController::class, 'tambahpilmatkul'])->name('tambahpilmatkul');
Route::post('admin/pilmatkul/tambah/{id}', [AdminController::class, 'postpilmatkul'])->name('postpilmatkul');
Route::delete('admin/pilmatkul/hapus/{id}', [AdminController::class, 'hapuspilmatkul'])->name('hapuspilmatkul');
Route::get('admin/pilmatkul/edit/{id}/{m}', [AdminController::class, 'editpilmatkul'])->name('editpilmatkul');


// verifikasi
Route::get('admin/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
Route::post('admin/verifikasi/post', [AdminController::class, 'postverifikasi'])->name('postverifikasi');


Route::get('login', [AdminController::class, 'login'])->name('login');
