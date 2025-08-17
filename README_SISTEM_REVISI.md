# Sistem Revisi Penawaran

## Deskripsi
Sistem ini memungkinkan pembuatan revisi penawaran dengan nomor yang sama namun ditambah suffix R1, R2, atau R3. Revisi tidak mempengaruhi nomor urut penawaran bulanan.

## Fitur Utama

### 1. **Sistem Nomor Revisi**
- **Format**: `XX/MKI/MM/YY R1`, `XX/MKI/MM/YY R2`, `XX/MKI/MM/YY R3`
- **Maksimal**: 3 revisi per penawaran
- **Tidak Mempengaruhi**: Nomor urut bulanan

### 2. **Contoh Perhitungan**
```
Bulan Juli 2025:
- Penawaran 1: 01/MKI/07/25
- Revisi 1: 01/MKI/07/25 R1
- Revisi 2: 01/MKI/07/25 R2
- Penawaran 2: 02/MKI/07/25 (bukan 03!)
```

## Implementasi

### 1. **Database Migration**
File: `database/migrations/2024_01_01_000000_add_is_revisi_to_penawarans_table.php`

```php
Schema::table('penawarans', function (Blueprint $table) {
    $table->boolean('is_revisi')->default(false)->after('penawaran_pintu');
    $table->unsignedBigInteger('revisi_from')->nullable()->after('is_revisi');
    $table->foreign('revisi_from')->references('id')->on('penawarans')->onDelete('set null');
});
```

### 2. **Model Penawaran**
File: `app/Models/Penawaran.php`

#### Field Baru:
- `is_revisi`: Boolean, menandakan apakah ini revisi
- `revisi_from`: ID penawaran asli yang direvisi
- `catatan_revisi`: Catatan alasan revisi

#### Method Helper:
```php
// Cek apakah bisa buat revisi
public function canCreateRevisi()

// Get nomor tanpa suffix revisi
public function getNomorAsliAttribute()

// Get status revisi (R1, R2, R3)
public function getStatusRevisiAttribute()

// Relasi ke penawaran asli
public function penawaranAsli()

// Relasi ke semua revisi
public function revisi()
```

### 3. **Trait NomorPenawaranGenerator**
File: `app/Traits/NomorPenawaranGenerator.php`

#### Method Utama:
```php
// Generate nomor penawaran baru (hanya dari penawaran asli)
protected function generateNomorPenawaran()

// Generate nomor revisi
protected function generateNomorRevisi($nomorAsli)

// Cek apakah bisa buat revisi
protected function canCreateRevisi($nomorPenawaran)
```

### 4. **Controller**
#### PenawaranController:
- `createRevisi()`: Tampilkan form revisi
- `storeRevisi()`: Simpan revisi

#### PenawaranPintuController:
- `createRevisi()`: Tampilkan form revisi pintu
- `storeRevisi()`: Simpan revisi pintu

### 5. **Routes**
```php
// Penawaran biasa
Route::get('penawaran/{penawaran}/revisi', [PenawaranController::class, 'createRevisi'])->name('penawaran.create-revisi');
Route::post('penawaran/{penawaran}/revisi', [PenawaranController::class, 'storeRevisi'])->name('penawaran.store-revisi');

// Penawaran pintu
Route::get('penawaran-pintu/{penawaran}/revisi', [PenawaranPintuController::class, 'createRevisi'])->name('penawaran-pintu.create-revisi');
Route::post('penawaran-pintu/{penawaran}/revisi', [PenawaranPintuController::class, 'storeRevisi'])->name('penawaran-pintu.store-revisi');
```

### 6. **Views**
#### Form Revisi:
- `resources/views/admin/penawaran/create-revisi.blade.php`
- `resources/views/admin/penawaran-pintu/create-revisi.blade.php`

#### Tombol Revisi:
- Ditambahkan di `show.blade.php` kedua jenis penawaran
- Hanya muncul jika bisa buat revisi

## Cara Kerja

### 1. **Pembuatan Revisi**
1. User klik tombol "Buat Revisi" di detail penawaran
2. Sistem cek apakah bisa buat revisi (maksimal 3)
3. Form revisi ditampilkan dengan data yang sudah ter-copy
4. User bisa edit data yang perlu diubah
5. Sistem generate nomor revisi otomatis (R1, R2, R3)

### 2. **Perhitungan Nomor**
```php
// Cari penawaran terakhir di bulan yang sama (TANPA revisi)
$lastPenawaranThisMonth = Penawaran::whereYear('created_at', date('Y'))
    ->whereMonth('created_at', date('m'))
    ->where('is_revisi', false) // Hanya penawaran asli
    ->latest()
    ->first();

// Generate nomor revisi
$nomorAsli = preg_replace('/\s+R\d+$/', '', $penawaran->nomor_penawaran);
$data['nomor_penawaran'] = $this->generateNomorRevisi($nomorAsli);
```

### 3. **Validasi Revisi**
- Maksimal 3 revisi per penawaran
- Hanya penawaran asli yang bisa direvisi
- Revisi tidak bisa direvisi lagi

## Keuntungan Sistem

1. **Tracking Lengkap**: Setiap revisi tercatat dengan jelas
2. **Nomor Urut Konsisten**: Revisi tidak mengganggu urutan bulanan
3. **Data Ter-copy**: Semua data penawaran asli tersalin otomatis
4. **Fleksibilitas**: User bisa edit data yang perlu diubah
5. **Audit Trail**: Jelas mana yang asli, mana yang revisi

## Contoh Penggunaan

### Skenario 1: Revisi Harga
1. Penawaran dibuat: `01/MKI/07/25`
2. Client minta revisi harga
3. Buat revisi: `01/MKI/07/25 R1`
4. Edit harga sesuai permintaan
5. Penawaran berikutnya tetap: `02/MKI/07/25`

### Skenario 2: Revisi Spesifikasi
1. Penawaran: `01/MKI/07/25`
2. Revisi 1: `01/MKI/07/25 R1` (harga)
3. Revisi 2: `01/MKI/07/25 R2` (spesifikasi)
4. Revisi 3: `01/MKI/07/25 R3` (warna)
5. Tidak bisa buat revisi lagi (maksimal 3)

## Troubleshooting

### Jika revisi tidak bisa dibuat:
1. Cek apakah sudah maksimal 3 revisi
2. Pastikan field `is_revisi` dan `revisi_from` sudah ada di database
3. Jalankan migration jika belum

### Jika nomor revisi salah:
1. Periksa method `generateNomorRevisi()`
2. Pastikan regex pattern sudah benar
3. Cek apakah ada karakter khusus di nomor penawaran

### Jika data tidak ter-copy:
1. Periksa form revisi
2. Pastikan data dari penawaran asli tersedia
3. Cek apakah ada error di log Laravel
