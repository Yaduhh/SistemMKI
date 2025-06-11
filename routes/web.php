<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\AksesorisController;
use App\Http\Controllers\Admin\SyaratController;
use App\Http\Controllers\Admin\SuratJalanController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Pengajuan\PengajuanController;
use App\Http\Controllers\Admin\DailyActivityController;
use App\Http\Controllers\Admin\DeckingController;
use App\Http\Controllers\Admin\FacadeController;
use App\Http\Controllers\Admin\FlooringController;
use App\Http\Controllers\Admin\WallpanelController;
use App\Http\Controllers\Admin\CeilingController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Redirect dashboard based on user role
Route::get('dashboard', function () {
    if (auth()->user()->role === 1) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 2) {
        return redirect()->route('sales.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Add new route group for sales users (role 2)
Route::middleware(['auth', 'role:2'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('dashboard');
    
    // Event Routes for Sales
    Route::get('events/dashboard', [App\Http\Controllers\Sales\EventController::class, 'dashboard'])->name('events.dashboard');
    Route::get('events/upcoming', [App\Http\Controllers\Sales\EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('events/my-upcoming', [App\Http\Controllers\Sales\EventController::class, 'myUpcoming'])->name('events.my-upcoming');
    Route::get('events/past', [App\Http\Controllers\Sales\EventController::class, 'past'])->name('events.past');
    Route::get('events/{event}', [App\Http\Controllers\Sales\EventController::class, 'show'])->name('events.show');
    
    // Daily Activity Routes for Sales
    Route::get('/daily-activity', [App\Http\Controllers\Sales\DailyActivityController::class, 'index'])->name('daily-activity.index');
    Route::get('/daily-activity/create', [App\Http\Controllers\Sales\DailyActivityController::class, 'create'])->name('daily-activity.create');
    Route::post('/daily-activity', [App\Http\Controllers\Sales\DailyActivityController::class, 'store'])->name('daily-activity.store');
    Route::get('/daily-activity/{dailyActivity}', [App\Http\Controllers\Sales\DailyActivityController::class, 'show'])->name('daily-activity.show');
    Route::get('/daily-activity/{dailyActivity}/edit', [App\Http\Controllers\Sales\DailyActivityController::class, 'edit'])->name('daily-activity.edit');
    Route::put('/daily-activity/{dailyActivity}', [App\Http\Controllers\Sales\DailyActivityController::class, 'update'])->name('daily-activity.update');
    Route::delete('/daily-activity/{dailyActivity}', [App\Http\Controllers\Sales\DailyActivityController::class, 'destroy'])->name('daily-activity.destroy');
    Route::post('/daily-activity/{dailyActivity}/comment', [App\Http\Controllers\Sales\DailyActivityController::class, 'comment'])->name('daily-activity.comment');

    // Client Routes for Sales
    Route::resource('client', App\Http\Controllers\Sales\ClientController::class);

    // Settings Route - using view with sales layout
    Route::view('/setting', 'sales.setting.index')->name('setting.index');
});

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

// ROUTE FOR ADMIN & SALES
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('pengajuan', PengajuanController::class);
    Route::put('pengajuan/{pengajuan}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::put('pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
    Route::get('admin/pengajuan/cetak/{id}', [PengajuanController::class, 'cetak'])->name('pengajuan.cetak');
    Route::get('admin/surat-jalan/cetak/{id}', [SuratJalanController::class, 'cetak'])->name('surat_jalan.cetak');
    
    // Daily Activity Routes for Admin
    Route::middleware(['role:1'])->group(function () {
        // Daily Activity Routes for Sales
        Route::get('/daily-activity', [DailyActivityController::class, 'index'])->name('daily-activity.index');
        Route::get('/daily-activity/create', [DailyActivityController::class, 'create'])->name('daily-activity.create');
        Route::post('/daily-activity', [DailyActivityController::class, 'store'])->name('daily-activity.store');
        Route::get('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'show'])->name('daily-activity.show');
        Route::get('/daily-activity/{dailyActivity}/edit', [DailyActivityController::class, 'edit'])->name('daily-activity.edit');
        Route::put('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'update'])->name('daily-activity.update');
        Route::delete('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'destroy'])->name('daily-activity.destroy');
        Route::post('/daily-activity/{dailyActivity}/comment', [DailyActivityController::class, 'comment'])->name('daily-activity.comment');

        // Event Routes - moved here to avoid conflicts
        Route::get('events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
        Route::get('events/past', [EventController::class, 'past'])->name('events.past');
        Route::get('events/cancelled', [EventController::class, 'cancelled'])->name('events.cancelled');
        Route::get('events/completed', [EventController::class, 'completed'])->name('events.completed');
        Route::get('events/deleted', [EventController::class, 'deleted'])->name('events.deleted');
        Route::post('events/{id}/restore', [EventController::class, 'restore'])->name('events.restore');
        Route::delete('events/{id}/force-delete', [EventController::class, 'forceDelete'])->name('events.force-delete');
        Route::put('events/{event}/update-status', [EventController::class, 'updateStatus'])->name('events.update-status');
        Route::resource('events', EventController::class);
    });
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Distributor Routes
    Route::get('distributor/logs', [DistributorController::class, 'logs'])->name('distributor.logs');
    Route::resource('distributor', DistributorController::class);

    // Client Routes
    Route::resource('client', ClientController::class);
    Route::resource('decking', DeckingController::class);
    Route::resource('facade', FacadeController::class);
    Route::resource('flooring', FlooringController::class);
    Route::resource('wallpanel', WallpanelController::class);
    Route::resource('ceiling', CeilingController::class);
    Route::resource('penawaran', App\Http\Controllers\Admin\PenawaranController::class);
});

Route::middleware(['auth', 'role:1'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('logs', [App\Http\Controllers\Admin\DashboardController::class, 'logs'])->name('logs');
    
    // Akun Management Routes
    Route::get('akun', App\Livewire\Admin\UserIndex::class)->name('akun.index');
    Route::get('akun/create', App\Livewire\Admin\CreateUser::class)->name('akun.create');
    Route::get('akun/{akun}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('akun/{akun}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('akun/{akun}', [AkunController::class, 'destroy'])->name('akun.destroy');

    // Settings Route - using view with admin layout
    Route::view('/setting', 'admin.setting.index')->name('setting.index');
});

require __DIR__.'/auth.php';
