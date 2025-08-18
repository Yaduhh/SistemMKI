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
use App\Http\Controllers\Admin\ArsipFileController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Pengajuan\PengajuanController;
use App\Http\Controllers\Admin\DailyActivityController;
use App\Http\Controllers\Admin\DeckingController;
use App\Http\Controllers\Admin\FacadeController;
use App\Http\Controllers\Admin\FlooringController;
use App\Http\Controllers\Admin\WallpanelController;
use App\Http\Controllers\Admin\CeilingController;
use App\Http\Controllers\Admin\SyaratPemasanganController;
use App\Http\Controllers\Admin\RancanganAnggaranBiayaController;
use App\Http\Controllers\Admin\EntertainmentController;
use App\Http\Controllers\Admin\PintuController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Redirect dashboard based on user role
Route::get('dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if ($user->role === 2) {
        return redirect()->route('sales.dashboard');
    } elseif ($user->role === 3) {
        return redirect()->route('finance.dashboard');
    } elseif ($user->role === 4) {
        return redirect()->route('supervisi.dashboard');
    } elseif ($user->role === 1) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');

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

    // Absensi Route
    Route::get('/absensi', [App\Http\Controllers\Sales\AbsensiController::class, 'index'])->name('absensi.index');

    // Arsip File Routes
    Route::post('/arsip-file', [App\Http\Controllers\Sales\ArsipFileController::class, 'store'])->name('arsip-file.store');
    Route::delete('/arsip-file/{arsipFile}', [App\Http\Controllers\Sales\ArsipFileController::class, 'destroy'])->name('arsip-file.destroy');
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

Route::middleware(['auth', 'role:1,3'])->prefix('admin')->group(function () {
    Route::get('produk', [ProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('produk/create', [ProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('produk', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('produk/{id}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('produk/{id}', [ProdukController::class, 'destroy'])->name('admin.produk.destroy');
});

Route::middleware(['auth', 'role:1,3'])->prefix('admin')->group(function () {
    Route::get('aksesoris', [AksesorisController::class, 'index'])->name('admin.aksesoris.index');
    Route::get('aksesoris/create', [AksesorisController::class, 'create'])->name('admin.aksesoris.create');
    Route::post('aksesoris', [AksesorisController::class, 'store'])->name('admin.aksesoris.store');
    Route::get('aksesoris/{id}/edit', [AksesorisController::class, 'edit'])->name('admin.aksesoris.edit');
    Route::put('aksesoris/{id}', [AksesorisController::class, 'update'])->name('admin.aksesoris.update');
    Route::delete('aksesoris/{id}', [AksesorisController::class, 'destroy'])->name('admin.aksesoris.destroy');
});

Route::middleware(['auth', 'role:1,3'])->prefix('admin')->group(function () {
    Route::get('syarat-ketentuan', [SyaratController::class, 'index'])->name('admin.syarat_ketentuan.index');
    Route::get('syarat-ketentuan/create', [SyaratController::class, 'create'])->name('admin.syarat_ketentuan.create');
    Route::post('syarat-ketentuan', [SyaratController::class, 'store'])->name('admin.syarat_ketentuan.store');
    Route::get('syarat-ketentuan/{id}/edit', [SyaratController::class, 'edit'])->name('admin.syarat_ketentuan.edit');
    Route::put('syarat-ketentuan/{id}', [SyaratController::class, 'update'])->name('admin.syarat_ketentuan.update');
    Route::delete('syarat-ketentuan/{id}', [SyaratController::class, 'destroy'])->name('admin.syarat_ketentuan.destroy');
    
    // Syarat Pintu Routes
    Route::get('syarat-pintu', [App\Http\Controllers\Admin\SyaratPintuController::class, 'index'])->name('admin.syarat-pintu.index');
    Route::get('syarat-pintu/create', [App\Http\Controllers\Admin\SyaratPintuController::class, 'create'])->name('admin.syarat-pintu.create');
    Route::post('syarat-pintu', [App\Http\Controllers\Admin\SyaratPintuController::class, 'store'])->name('admin.syarat-pintu.store');
    Route::get('syarat-pintu/{id}/edit', [App\Http\Controllers\Admin\SyaratPintuController::class, 'edit'])->name('admin.syarat-pintu.edit');
    Route::put('syarat-pintu/{id}', [App\Http\Controllers\Admin\SyaratPintuController::class, 'update'])->name('admin.syarat-pintu.update');
    Route::delete('syarat-pintu/{id}', [App\Http\Controllers\Admin\SyaratPintuController::class, 'destroy'])->name('admin.syarat-pintu.destroy');
});

Route::middleware(['auth', 'role:1,3,4'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('logs', [App\Http\Controllers\Admin\DashboardController::class, 'logs'])->name('logs');
    
    // Akun Management Routes
    Route::get('akun', App\Livewire\Admin\UserIndex::class)->name('akun.index');
    Route::get('akun/create', App\Livewire\Admin\CreateUser::class)->name('akun.create');
    Route::get('akun/{akun}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('akun/{akun}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('akun/{akun}', [AkunController::class, 'destroy'])->name('akun.destroy');

    // Absensi Routes
    Route::resource('absensi', App\Http\Controllers\Admin\AbsensiController::class);

    // Settings Route - using view with admin layout
    Route::view('/setting', 'admin.setting.index')->name('setting.index');

        // Distributor Routes
    Route::get('distributor/logs', [DistributorController::class, 'logs'])->name('distributor.logs');
    Route::resource('distributor', DistributorController::class);

    // Client Routes
    Route::get('client/{client}/download', [ClientController::class, 'download'])->name('client.download');
    Route::resource('client', ClientController::class);
    
    // Arsip File Routes
    Route::resource('arsip-file', ArsipFileController::class);
    Route::resource('decking', DeckingController::class);
    Route::resource('facade', FacadeController::class);
    Route::resource('flooring', FlooringController::class);
    Route::resource('wallpanel', WallpanelController::class);
    Route::resource('ceiling', CeilingController::class);
    Route::resource('pintu', PintuController::class);
    Route::resource('syarat-pemasangan', SyaratPemasanganController::class);
    Route::resource('penawaran', App\Http\Controllers\Admin\PenawaranController::class);
    Route::get('penawaran/clients/{salesId}', [App\Http\Controllers\Admin\PenawaranController::class, 'getClientsBySales'])->name('penawaran.clients');
    Route::get('penawaran/cetak/{id}', [App\Http\Controllers\Admin\PenawaranController::class, 'cetak'])->name('penawaran.cetak');
    Route::patch('penawaran/{penawaran}/update-status', [App\Http\Controllers\Admin\PenawaranController::class, 'updateStatus'])->name('penawaran.update-status');
Route::get('penawaran/{penawaran}/revisi', [App\Http\Controllers\Admin\PenawaranController::class, 'createRevisi'])->name('penawaran.create-revisi');
Route::post('penawaran/{penawaran}/revisi', [App\Http\Controllers\Admin\PenawaranController::class, 'storeRevisi'])->name('penawaran.store-revisi');

    // Penawaran Pintu Routes
    Route::resource('penawaran-pintu', App\Http\Controllers\Admin\PenawaranPintuController::class)->parameters(['penawaran-pintu' => 'penawaran']);
    Route::get('penawaran-pintu/clients/{salesId}', [App\Http\Controllers\Admin\PenawaranPintuController::class, 'getClientsBySales'])->name('penawaran-pintu.clients');
    Route::get('penawaran-pintu/cetak/{id}', [App\Http\Controllers\Admin\PenawaranPintuController::class, 'cetak'])->name('penawaran-pintu.cetak');
    Route::patch('penawaran-pintu/{penawaran}/update-status', [App\Http\Controllers\Admin\PenawaranPintuController::class, 'updateStatus'])->name('penawaran-pintu.update-status');
Route::get('penawaran-pintu/{penawaran}/revisi', [App\Http\Controllers\Admin\PenawaranPintuController::class, 'createRevisi'])->name('penawaran-pintu.create-revisi');
Route::post('penawaran-pintu/{penawaran}/revisi', [App\Http\Controllers\Admin\PenawaranPintuController::class, 'storeRevisi'])->name('penawaran-pintu.store-revisi');

    Route::resource('pengajuan', PengajuanController::class);
    Route::put('pengajuan/{pengajuan}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::put('pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
    Route::get('admin/pengajuan/cetak/{id}', [PengajuanController::class, 'cetak'])->name('pengajuan.cetak');
    Route::get('admin/surat-jalan/cetak/{id}', [SuratJalanController::class, 'cetak'])->name('surat_jalan.cetak');
    
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
    Route::get('pemasangan/cetak/{id}', [App\Http\Controllers\Admin\PemasanganController::class, 'cetak'])->name('pemasangan.cetak');
    Route::resource('pemasangan', App\Http\Controllers\Admin\PemasanganController::class);
    Route::patch('pemasangan/{pemasangan}/update-status', [App\Http\Controllers\Admin\PemasanganController::class, 'updateStatus'])->name('pemasangan.update-status');
    
    // Rancangan Anggaran Biaya Routes
    Route::resource('rancangan-anggaran-biaya', App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class);
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/export-pdf', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'exportPdf'])->name('rancangan-anggaran-biaya.export-pdf');
    Route::patch('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/update-status', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'updateStatus'])->name('rancangan-anggaran-biaya.update-status');
    Route::patch('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/update-supervisi', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'updateSupervisi'])->name('rancangan-anggaran-biaya.update-supervisi');
    
    // Routes untuk tambah pengeluaran
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/tambah-entertainment', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'tambahEntertainment'])->name('rancangan-anggaran-biaya.tambah-entertainment');
    Route::post('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/store-entertainment', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'storeEntertainment'])->name('rancangan-anggaran-biaya.store-entertainment');
    
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/tambah-akomodasi', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'tambahAkomodasi'])->name('rancangan-anggaran-biaya.tambah-akomodasi');
    Route::post('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/store-akomodasi', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'storeAkomodasi'])->name('rancangan-anggaran-biaya.store-akomodasi');
    
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/tambah-lainnya', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'tambahLainnya'])->name('rancangan-anggaran-biaya.tambah-lainnya');
    Route::post('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/store-lainnya', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'storeLainnya'])->name('rancangan-anggaran-biaya.store-lainnya');
    
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/tambah-tukang', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'tambahTukang'])->name('rancangan-anggaran-biaya.tambah-tukang');
    Route::post('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/store-tukang', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'storeTukang'])->name('rancangan-anggaran-biaya.store-tukang');
    
    Route::get('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/tambah-kerja-tambah', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'tambahKerjaTambah'])->name('rancangan-anggaran-biaya.tambah-kerja-tambah');
    Route::post('rancangan-anggaran-biaya/{rancanganAnggaranBiaya}/store-kerja-tambah', [App\Http\Controllers\Admin\RancanganAnggaranBiayaController::class, 'storeKerjaTambah'])->name('rancangan-anggaran-biaya.store-kerja-tambah');
    
    // Entertainment Routes
    Route::get('entertainment', [App\Http\Controllers\Admin\EntertainmentController::class, 'index'])->name('entertainment.index');
    Route::patch('entertainment/{id}/update-status', [App\Http\Controllers\Admin\EntertainmentController::class, 'updateStatus'])->name('entertainment.update-status');
    
    // Akomodasi Routes
    Route::get('akomodasi', [App\Http\Controllers\Admin\AkomodasiController::class, 'index'])->name('akomodasi.index');
    Route::patch('akomodasi/{id}/update-status', [App\Http\Controllers\Admin\AkomodasiController::class, 'updateStatus'])->name('akomodasi.update-status');
});

// Finance routes for role 3
Route::middleware(['auth', 'role:3'])->prefix('finance')->name('finance.')->group(function () {
    // Finance Dashboard
    Route::get('dashboard', [App\Http\Controllers\Finance\DashboardController::class, 'index'])->name('dashboard');
    Route::get('logs', [App\Http\Controllers\Finance\DashboardController::class, 'logs'])->name('logs');

    // Client Routes
    Route::get('client/{client}/download', [App\Http\Controllers\Finance\ClientController::class, 'download'])->name('client.download');
    Route::resource('client', App\Http\Controllers\Finance\ClientController::class);

     // Daily Activity Routes for Finance
    Route::get('/daily-activity', [App\Http\Controllers\Finance\DailyActivityController::class, 'index'])->name('daily-activity.index');
    Route::get('/daily-activity/create', [App\Http\Controllers\Finance\DailyActivityController::class, 'create'])->name('daily-activity.create');
    Route::post('/daily-activity', [App\Http\Controllers\Finance\DailyActivityController::class, 'store'])->name('daily-activity.store');
    Route::get('/daily-activity/{dailyActivity}', [App\Http\Controllers\Finance\DailyActivityController::class, 'show'])->name('daily-activity.show');
    Route::get('/daily-activity/{dailyActivity}/edit', [App\Http\Controllers\Finance\DailyActivityController::class, 'edit'])->name('daily-activity.edit');
    Route::put('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'update'])->name('daily-activity.update');
    Route::delete('/daily-activity/{dailyActivity}', [DailyActivityController::class, 'destroy'])->name('daily-activity.destroy');
    Route::post('/daily-activity/{dailyActivity}/comment', [DailyActivityController::class, 'comment'])->name('daily-activity.comment');
    Route::resource('arsip-file', ArsipFileController::class);

    // Event Finance
    // Event Routes for Sales
    Route::get('events/dashboard', [App\Http\Controllers\Finance\EventController::class, 'dashboard'])->name('events.dashboard');
    Route::get('events/upcoming', [App\Http\Controllers\Finance\EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('events/my-upcoming', [App\Http\Controllers\Finance\EventController::class, 'myUpcoming'])->name('events.my-upcoming');
    Route::get('events/past', [App\Http\Controllers\Finance\EventController::class, 'past'])->name('events.past');
    Route::get('events/{event}', [App\Http\Controllers\Finance\EventController::class, 'show'])->name('events.show');
});

// Supervisi routes for role 4
Route::middleware(['auth', 'role:4'])->prefix('supervisi')->name('supervisi.')->group(function () {
    // Supervisi Dashboard
    Route::get('dashboard', [App\Http\Controllers\Supervisi\DashboardController::class, 'index'])->name('dashboard');
    Route::get('logs', [App\Http\Controllers\Supervisi\DashboardController::class, 'logs'])->name('logs');

                    // RAB Routes
                Route::resource('rab', App\Http\Controllers\Supervisi\RabController::class)->only(['index', 'show']);
                Route::patch('rab/{rab}/update-entertainment', [App\Http\Controllers\Supervisi\RabController::class, 'updateEntertainment'])->name('rab.update-entertainment');

    // Settings Route
    Route::view('/setting', 'supervisi.setting.index')->name('setting.index');
});

require __DIR__.'/auth.php';
