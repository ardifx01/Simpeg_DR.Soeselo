<?php

use App\Models\Keterangan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\IstriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\HukumanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EpersonalController;
use App\Http\Controllers\NominatifController;
use App\Http\Controllers\PembinaanController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\KeteranganController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\IjinBelajarController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\DiklatteknikController;
use App\Http\Controllers\PegawaiPrintController;
use App\Http\Controllers\TugasBelajarController;
use App\Http\Controllers\DiklatJabatanController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DiklatFungsionalController;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});

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
    Route::put('/dashboard/pegawai/{id}/update-image', [PegawaiController::class, 'updateImage'])->name('pegawai.update-image');
    Route::get('/pegawai/search', [PegawaiController::class, 'search'])->name('pegawai.search');
    Route::get('/arsip/view/{id}', [ArsipController::class, 'arsipView'])->name('arsip.view');
    Route::get('/rekap-kgb-pangkat', [App\Http\Controllers\PegawaiController::class, 'rekapKGBPangkat'])->name('rekap.kgbpangkat');
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

    Route::post('/pegawai/{id}/print/preview', [PegawaiPrintController::class, 'preview'])->name('pegawai.print.preview');
    Route::post('/pegawai/{id}/print/cetak', [PegawaiPrintController::class, 'cetak'])->name('pegawai.print.cetak');

    Route::get('/dashboard/statistik', [StatistikController::class, 'index'])->name('statistik.index');
    Route::get('/statistik/preview', [StatistikController::class, 'preview'])->name('statistik.preview');
    Route::get('/dashboard/statistik/cetak_pdf', [StatistikController::class, 'cetak'])->name('statistik.cetak');
    Route::prefix('/dashboard/nominatif')->name('dashboard.nominatif.')->group(function () {
        Route::get('/', [NominatifController::class, 'index'])->name('index');
        Route::post('/show', [NominatifController::class, 'show'])->name('show');
        Route::get('/cetak', [NominatifController::class, 'cetak'])->name('cetak');
        Route::get('/preview', [NominatifController::class, 'preview'])->name('preview');
    });
    Route::get('/dashboard/rekap-golongan', [PegawaiController::class, 'rekapGolongan'])->name('rekap.golongan');
    Route::get('/dashboard/rekap-jabatan', [JabatanController::class, 'rekapJabatan'])->name('rekap.jabatan');
    Route::get('/dashboard/rekap-eselon', [JabatanController::class, 'rekapEselon'])->name('rekap.eselon');
    Route::get('/dashboard/rekap-kepegawaian', [JabatanController::class, 'rekapKepegawaian'])->name('rekap.kepegawaian');
    Route::get('/dashboard/rekap-agama', [PegawaiController::class, 'rekapAgama'])->name('rekap.agama');
    Route::get('/dashboard/rekap-jenis-kelamin', [PegawaiController::class, 'rekapJenisKelamin'])->name('rekap.jeniskelamin');
    Route::get('/dashboard/rekap-status-nikah', [PegawaiController::class, 'rekapStatusNikah'])->name('rekap.statusnikah');
    Route::get('/dashboard/rekap-pendidikan-akhir', [PendidikanController::class, 'rekapPendidikanAkhir'])->name('rekap.pendidikanakhir');

    Route::get('/surat', [SuratController::class, 'index'])->name('surat');
    Route::get('/api/pegawai/{id}', [PegawaiController::class, 'getData']);
    Route::resource('cuti', CutiController::class);
    Route::get('/cuti/{id}/export', [CutiController::class, 'export'])->name('cuti.export');
    Route::resource('keterangan', KeteranganController::class);
    Route::get('/keterangan/{id}/export', [KeteranganController::class, 'export'])->name('keterangan.export');
    Route::resource('tugas_belajar', TugasBelajarController::class);
    Route::get('/tugas_belajar/{id}/export', [TugasBelajarController::class, 'export'])->name('tugas_belajar.export');
    Route::resource('hukuman', HukumanController::class);
    Route::get('/hukuman/{id}/export', [HukumanController::class, 'export'])->name('hukuman.export');
    Route::resource('pembinaan', PembinaanController::class);
    Route::get('/pembinaan/{id}/export', [PembinaanController::class, 'export'])->name('pembinaan.export');
    
});
