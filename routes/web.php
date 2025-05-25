<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\AksesorisController;
use App\Http\Controllers\Admin\SyaratController;
use App\Http\Controllers\Admin\SuratJalanController;
use App\Http\Controllers\Pengajuan\PengajuanController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('surat_jalan', SuratJalanController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('produk', [ProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('produk/create', [ProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('produk', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('produk/{id}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('produk/{id}', [ProdukController::class, 'destroy'])->name('admin.produk.destroy');
});

Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('aksesoris', [AksesorisController::class, 'index'])->name('admin.aksesoris.index');
    Route::get('aksesoris/create', [AksesorisController::class, 'create'])->name('admin.aksesoris.create');
    Route::post('aksesoris', [AksesorisController::class, 'store'])->name('admin.aksesoris.store');
    Route::get('aksesoris/{id}/edit', [AksesorisController::class, 'edit'])->name('admin.aksesoris.edit');
    Route::put('aksesoris/{id}', [AksesorisController::class, 'update'])->name('admin.aksesoris.update');
    Route::delete('aksesoris/{id}', [AksesorisController::class, 'destroy'])->name('admin.aksesoris.destroy');
});

Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('syarat-ketentuan', [SyaratController::class, 'index'])->name('admin.syarat_ketentuan.index');
    Route::get('syarat-ketentuan/create', [SyaratController::class, 'create'])->name('admin.syarat_ketentuan.create');
    Route::post('syarat-ketentuan', [SyaratController::class, 'store'])->name('admin.syarat_ketentuan.store');
    Route::get('syarat-ketentuan/{id}/edit', [SyaratController::class, 'edit'])->name('admin.syarat_ketentuan.edit');
    Route::put('syarat-ketentuan/{id}', [SyaratController::class, 'update'])->name('admin.syarat_ketentuan.update');
    Route::delete('syarat-ketentuan/{id}', [SyaratController::class, 'destroy'])->name('admin.syarat_ketentuan.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('pengajuan', PengajuanController::class);
    Route::get('admin/pengajuan/cetak/{id}', [PengajuanController::class, 'cetak'])->name('pengajuan.cetak');
    Route::get('admin/surat-jalan/cetak/{id}', [SuratJalanController::class, 'cetak'])->name('surat_jalan.cetak');
});

require __DIR__.'/auth.php';
