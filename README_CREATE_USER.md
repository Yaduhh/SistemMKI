# Fitur Create User untuk Admin

## Deskripsi
Fitur ini memungkinkan admin untuk membuat user baru dengan tampilan yang profesional dan user-friendly. Halaman ini menggunakan Livewire untuk interaksi real-time dan validasi.

## Fitur Utama

### 1. Form Input Lengkap
- **Nama Lengkap**: Input text untuk nama user
- **Email**: Input email dengan validasi unik
- **Nomor Telepon**: Input opsional untuk nomor telepon
- **Role**: Dropdown untuk memilih role (Admin/Sales)
- **Password**: Input password dengan konfirmasi
- **Status Akun**: Checkbox untuk mengaktifkan/menonaktifkan akun
- **Foto Profil**: Upload gambar opsional dengan preview

### 2. Validasi
- Validasi required fields (nama, email, password, role)
- Validasi email unik
- Validasi password confirmation
- Validasi format gambar (JPG, JPEG, PNG, max 2MB)
- Validasi password strength (minimal 8 karakter)

### 3. UI/UX Profesional
- Design responsive dengan Tailwind CSS
- Dark mode support
- Loading states
- Success/error messages
- Form reset functionality
- Preview gambar profil
- Help section dengan informasi penting

### 4. Keamanan
- Hanya admin (role 1) yang bisa mengakses
- Password di-hash menggunakan bcrypt
- Validasi file upload
- CSRF protection

## Cara Menggunakan

### 1. Akses Halaman
- Login sebagai admin
- Klik menu "Akun" di sidebar
- Klik "Tambah User" atau tombol "Tambah Akun"

### 2. Isi Form
- Upload foto profil (opsional)
- Isi nama lengkap
- Masukkan email yang unik
- Isi nomor telepon (opsional)
- Pilih role (Admin/Sales)
- Masukkan password dan konfirmasi
- Aktifkan/nonaktifkan status akun

### 3. Submit
- Klik "Buat User" untuk menyimpan
- Atau klik "Reset Form" untuk mengosongkan form

## File yang Terlibat

### Livewire Component
- `app/Livewire/Admin/CreateUser.php` - Logic utama

### View
- `resources/views/livewire/admin/create-user.blade.php` - Template UI

### Routes
- `routes/web.php` - Route untuk halaman create

### Tests
- `tests/Feature/Admin/CreateUserTest.php` - Unit tests

## Model User Fields

```php
protected $fillable = [
    'name',           // Nama lengkap
    'email',          // Email (unique)
    'password',       // Password (hashed)
    'role',           // Role (1=Admin, 2=Sales)
    'notelp',         // Nomor telepon
    'profile',        // Path foto profil
    'status',         // Status aktif/nonaktif
    'status_deleted', // Soft delete flag
];
```

## Validasi Rules

```php
'name' => ['required', 'string', 'max:255'],
'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
'notelp' => ['nullable', 'string', 'max:20'],
'role' => ['required', 'integer', 'in:1,2'],
'status' => ['required', 'boolean'],
'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
```

## Error Handling

- **Validation Errors**: Ditampilkan di bawah setiap field
- **Success Message**: Flash message setelah berhasil create
- **File Upload Errors**: Validasi format dan ukuran file
- **Database Errors**: Handling untuk email duplikat

## Responsive Design

- **Desktop**: 2 kolom layout untuk form fields
- **Tablet**: Responsive grid dengan breakpoint md
- **Mobile**: Single column layout

## Dark Mode Support

- Semua komponen mendukung dark mode
- Warna yang konsisten dengan tema aplikasi
- Icon dan text yang readable di kedua mode

## Testing

Jalankan test dengan perintah:
```bash
php artisan test tests/Feature/Admin/CreateUserTest.php
```

Test mencakup:
- Akses halaman oleh admin
- Pembatasan akses untuk non-admin
- Validasi form
- Create user berhasil
- Reset form functionality 