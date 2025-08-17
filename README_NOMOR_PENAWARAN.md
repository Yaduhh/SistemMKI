# Sistem Nomor Penawaran Otomatis

## Deskripsi
Sistem ini secara otomatis menghasilkan nomor penawaran berdasarkan bulan dan tahun. Setiap bulan dimulai dari nomor 1, dan nomor akan increment secara berurutan dalam bulan yang sama.

## Format Nomor Penawaran
```
XX/MKI/MM/YY
```

### Keterangan:
- **XX**: Nomor urut bulanan (01, 02, 03, dst.)
- **MKI**: Kode perusahaan tetap
- **MM**: Bulan dalam 2 digit (01, 02, 03, dst.)
- **YY**: Tahun dalam 2 digit (25, 26, dst.)

### Contoh:
- **Januari 2025**: `01/MKI/01/25`, `02/MKI/01/25`, `03/MKI/01/25`
- **Februari 2025**: `01/MKI/02/25`, `02/MKI/02/25`
- **Maret 2025**: `01/MKI/03/25`

## Implementasi

### 1. Trait `NomorPenawaranGenerator`
File: `app/Traits/NomorPenawaranGenerator.php`

Trait ini berisi logika untuk generate nomor penawaran otomatis dan digunakan oleh kedua controller:
- `PenawaranController` (untuk penawaran produk)
- `PenawaranPintuController` (untuk penawaran pintu)

### 2. Logika Perhitungan
```php
// Cari penawaran terakhir di bulan yang sama
$lastPenawaranThisMonth = Penawaran::whereYear('created_at', date('Y'))
    ->whereMonth('created_at', date('m'))
    ->latest()
    ->first();

// Jika ada penawaran di bulan ini, increment nomor
if ($lastPenawaranThisMonth) {
    $lastNumber = (int)substr($lastPenawaranThisMonth->nomor_penawaran, 0, 2);
    $number = $lastNumber + 1;
} else {
    // Jika bulan baru, mulai dari 1
    $number = 1;
}
```

### 3. Penggunaan di Controller
```php
use App\Traits\NomorPenawaranGenerator;

class PenawaranController extends Controller
{
    use NomorPenawaranGenerator;
    
    public function store(StorePenawaranRequest $request)
    {
        // ... kode lainnya ...
        
        // Generate nomor penawaran otomatis
        $data['nomor_penawaran'] = $this->generateNomorPenawaran();
        
        // ... kode lainnya ...
    }
}
```

## Keuntungan Sistem Ini

1. **Otomatis**: Tidak perlu input manual nomor penawaran
2. **Berurutan**: Nomor selalu berurutan dalam bulan yang sama
3. **Reset Bulanan**: Setiap bulan dimulai dari nomor 1
4. **Konsisten**: Format yang sama untuk semua jenis penawaran
5. **Tidak Duplikat**: Tidak ada kemungkinan nomor ganda dalam bulan yang sama

## Catatan Penting

- Sistem ini menggunakan field `created_at` untuk menentukan bulan dan tahun
- Jika ada perubahan tanggal pembuatan, pastikan field `created_at` terisi dengan benar
- Sistem akan otomatis mencari penawaran terakhir di bulan yang sama untuk increment nomor
- Jika bulan baru, nomor akan otomatis reset ke 1

## Troubleshooting

### Jika nomor tidak increment:
1. Pastikan field `created_at` terisi dengan benar
2. Periksa apakah ada error di log Laravel
3. Pastikan model `Penawaran` memiliki timestamps yang aktif

### Jika format tidak sesuai:
1. Periksa implementasi method `generateNomorPenawaran()`
2. Pastikan format string yang digunakan sudah benar
3. Periksa apakah ada karakter khusus yang tidak diinginkan
