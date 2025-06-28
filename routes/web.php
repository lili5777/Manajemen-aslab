<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\IdcardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VerifikasiController;
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

// login
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    // Route::group(['middleware' => ['cek_login:admin']], function () {


    // dashboard
    Route::get('admin', [AdminController::class, 'index'])->name('admin');

    //ketentuan
    Route::get('admin/ketentuan', [AdminController::class, 'ketentuan'])->name('ketentuan');


    // pendaftar
    Route::get('admin/pendaftar', [AdminController::class, 'pendaftar'])->name('pendaftar');
    Route::get('admin/pendaftar/tambah', [AdminController::class, 'tambahpendaftar'])->name('tambahpendaftar');
    Route::get('admin/pendaftar/detail/{id}', [AdminController::class, 'detailpendaftar'])->name('detailpendaftar');
    Route::get('admin/pendaftar/edit/{id}', [AdminController::class, 'editpendaftar'])->name('editpendaftar');
    Route::post('admin/pendaftar/tambah', [AdminController::class, 'postpendaftar'])->name('postpendaftar');
    Route::delete('admin/pendaftar/hapus/{id}', [AdminController::class, 'hapuspendaftar'])->name('hapuspendaftar');


    // zpendaftar
    Route::get('admin/pendaftar_', [AdminController::class, 'zpendaftar'])->name('zpendaftar');

    // ambilkelas
    Route::get('admin/ambil/{id}', [AdminController::class, 'ambilkelas'])->name('ambilkelas');
    Route::get('admin/ambil2/{id}', [AdminController::class, 'ambilkelas2'])->name('ambilkelas2');


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
    Route::delete('admin/asdos/hapus/{id}', [AdminController::class, 'hapusasdos'])->name('hapusasdos');


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
    Route::get('admin/verifikasi', [VerifikasiController::class, 'verifikasi'])->name('verifikasi');
    Route::post('admin/verifikasi/post', [VerifikasiController::class, 'postverifikasi'])->name('postverifikasi');


    // absensi
    // Route::get('admin/absen', [AdminController::class, 'absen'])->name('absen');
    // Route::get('admin/absen/jadwal/{id}', [AdminController::class, 'jadwalasdos'])->name('jadwalasdoss');
    // Route::get('admin/absen/jadwal/riwayat/{id}/{asdos}', [AdminController::class, 'riwayatabsensi'])->name('riwayatabsensi');
    // Route::get('admin/absen/jadwal/riwayat/tambah/{id_jadwal}/{asdos}', [AdminController::class, 'tambahkehadiran'])->name('tambahriwayatabsensi');
    // Route::post('admin/absen/tambah', [AdminController::class, 'postkehadiran'])->name('postkehadiran');
    // Route::delete('admin/absen/hapus/{id}', [AdminController::class, 'hapuskehadiran'])->name('hapuskehadiran');
    // Route::get('admin/absen/jadwal/riwayat/tambah/{id}/{id_jadwal}/{asdos}', [AdminController::class, 'editkehadiran'])->name('editkehadiran');

    // updateabsensi
    Route::get('admin/absen', [AdminController::class, 'absensi2'])->name('absen');
    Route::get('admin/absen/{id}', [AdminController::class, 'detailabsensi2'])->name('detailabsen');
    Route::post('admin/absen/tambah', [AdminController::class, 'postabsensi2'])->name('postkehadiran');

    Route::get('admin/absensi_', [AdminController::class, 'kelolaabsensi'])->name('kelolaabsensi');
    Route::get('admin/absensi_/{id}', [AdminController::class, 'verifikasiabsensi'])->name('verifikasiabsensi');
    Route::get('admin/absen_/terima/{id}', [AdminController::class, 'terima_absensi'])->name('terima_absensi');

    // financial
    Route::get('admin/financial', [AdminController::class, 'financial'])->name('financial');
    Route::get('admin/rekapfinancial', [AdminController::class, 'rekapfinancial'])->name('rekapfinancial');

    // sertifikat
    Route::get('admin/sertifikat', [AdminController::class, 'sertifikat'])->name('sertifikat');
    Route::post('admin/absen/tambah', [AdminController::class, 'postabsensi2'])->name('postkehadiran');
    Route::post('admin/sertifikat/upload/{name}', [AdminController::class, 'uploadSertifikat'])->name('uploadSertifikat');

    // Route::post('admin/akun/tambah', [AdminController::class, 'postakun'])->name('postakun');
    // Route::get('admin/akun/edit/{id}', [AdminController::class, 'editakun'])->name('editakun');
    // Route::delete('admin/akun/hapus/{id}', [AdminController::class, 'hapusakun'])->name('hapusakun');
    // Route::get('admin/akun/detail/{id}', [AdminController::class, 'detailakun'])->name('detailakun');



    // });

    Route::get('id-card/{id}', [IdcardController::class, 'show'])->name('idcard.show');

    // setting
    Route::get('admin/setting/kriteria', [SettingController::class, 'kriteria'])->name('setting.kriteria');
    Route::put('admin/setting/kriteria/update/', [SettingController::class, 'kriteriaUpdate'])->name('setting.kriteriaUpdate');
    Route::get('admin/setting/batasan', [SettingController::class, 'batasan'])->name('setting.batasan');
    Route::put('admin/setting/batasan/update', [SettingController::class, 'batasanUpdate'])->name('setting.batasan.update');


    // excel
    // routes/web.php
    Route::get('admin/keuangan/export-excel', [ExportController::class, 'excelpendapatan'])
        ->name('keuangan.exportExcel');
});









Route::get('login', [AdminController::class, 'login'])->name('login');
