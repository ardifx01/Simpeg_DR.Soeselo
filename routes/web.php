<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\IstriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\IjinBelajarController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\DiklatteknikController;
use App\Http\Controllers\DiklatJabatanController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DiklatFungsionalController;
use App\Http\Controllers\EpersonalController;
use App\Http\Controllers\OPDController;

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/change-password', [ResetPasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/dashboard/change-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('search');
    Route::get('/dashoard/epersonal', [EpersonalController::class, 'index'])->name('dashboard.epersonal');
    Route::get('/search', [EpersonalController::class, 'search'])->name('search');
    Route::resource('/dashboard/pegawai', PegawaiController::class);
    Route::get('/pegawai/search', [PegawaiController::class, 'search'])->name('pegawai.search');
    Route::get('/arsip/view/{id}', [ArsipController::class, 'arsipView'])->name('arsip.view');
    Route::resource('/dashboard/opd', OPDController::class);
    Route::resource('/dashboard/istri', IstriController::class);
    Route::resource('/dashboard/anak', AnakController::class);
    Route::resource('/dashboard/diklatfungsional', DiklatFungsionalController::class);
    Route::resource('/dashboard/diklatjabatan', DiklatJabatanController::class);
    Route::resource('/dashboard/diklatteknik', DiklatteknikController::class);
    Route::resource('/dashboard/jabatan', JabatanController::class);
    Route::resource('/dashboard/penghargaan', PenghargaanController::class);
    Route::resource('/dashboard/organisasi', OrganisasiController::class);
    Route::resource('/dashboard/pendidikan', PendidikanController::class);
    Route::resource('/dashboard/ijinbelajar', IjinBelajarController::class);
    Route::resource('/dashboard/arsip', ArsipController::class);

    Route::post('/pegawai/{id}/print/generate', [App\Http\Controllers\PrintBiodataController::class, 'generatePDF'])->name('pegawai.print.generate');

    Route::get('/dashboard/rekap-golongan', [PegawaiController::class, 'rekapGolongan'])->name('rekap.golongan');
    Route::get('/dashboard/rekap-jabatan', [JabatanController::class, 'rekapJabatan'])->name('rekap.jabatan');
    Route::get('/dashboard/rekap-eselon', [JabatanController::class, 'rekapEselon'])->name('rekap.eselon');
    Route::get('/dashboard/rekap-kepegawaian', [PegawaiController::class, 'rekapKepegawaian'])->name('rekap.kepegawaian');
    Route::get('/dashboard/rekap-agama', [PegawaiController::class, 'rekapAgama'])->name('rekap.agama');
    Route::get('/dashboard/rekap-jenis-kelamin', [PegawaiController::class, 'rekapJenisKelamin'])->name('rekap.jeniskelamin');
    Route::get('/dashboard/rekap-status-nikah', [PegawaiController::class, 'rekapStatusNikah'])->name('rekap.statusnikah');
    Route::get('/dashboard/rekap-pendidikan-akhir', [PendidikanController::class, 'rekapPendidikanAkhir'])->name('rekap.pendidikanakhir');
    Route::get('/dashboard/rekap-opd-skpd-unit-kerja', [OPDController::class, 'rekapopd'])->name('rekap.opd');
});
