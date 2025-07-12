<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mendaftarkan middleware 'role' agar dapat digunakan
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);

        // Register Blade directive for Indonesian date formatting
        \Blade::directive('formatTanggalIndonesia', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::formatTanggalIndonesia($expression); ?>";
        });
    }

    /**
     * Format tanggal ke format Indonesia (contoh: 12 Juni 2025)
     */
    public static function formatTanggalIndonesia($date)
    {
        if (!$date) {
            return '-';
        }

        $carbon = Carbon::parse($date);
        
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $carbon->day . ' ' . $bulan[$carbon->month] . ' ' . $carbon->year;
    }
}
