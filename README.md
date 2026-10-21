# SplitTrip

SplitTrip adalah aplikasi web untuk mencatat dan membagi pengeluaran perjalanan bersama secara rapi. Buat satu trip, tambahkan anggota, catat siapa yang membayar, tentukan porsi setiap anggota, lalu gunakan logika ringkasan saldo untuk melihat posisi kontribusi tiap orang.

> Dibangun dengan Laravel 13, Blade, Tailwind CSS, dan Alpine.js.

## Fitur utama

- **Autentikasi pengguna**
  - Registrasi dan login
  - Verifikasi email
  - Lupa dan reset password
  - Konfirmasi password serta pengelolaan profil
- **Manajemen trip**
  - Membuat, melihat, mengubah, dan menghapus trip
  - Setiap trip hanya dapat dikelola oleh pembuatnya
- **Manajemen anggota**
  - Menambahkan anggota ke trip
  - Menghapus anggota dari trip
- **Pencatatan expense**
  - Menyimpan judul, nominal, tanggal, dan catatan pengeluaran
  - Mendukung lebih dari satu payer untuk satu expense
  - Memilih participant dari anggota trip
  - Tiga metode pembagian:
    - **Equal** — dibagi rata
    - **Custom amount** — nominal tiap orang ditentukan manual
    - **Percentage** — porsi ditentukan dalam persentase
  - Validasi agar total pembayaran payer dan total porsi participant selalu sesuai dengan nominal expense
- **Perhitungan kontribusi**
  - Menghitung total tanggungan setiap anggota
  - Menghitung total kontribusi dari pembayaran expense
  - Menghitung sisa yang masih harus dibayar atau diterima

## Teknologi

### Backend

- PHP `^8.3`
- Laravel `^13.17`
- Laravel Breeze untuk autentikasi
- Laravel Eloquent ORM
- SQLite sebagai database bawaan

### Frontend

- Blade templates
- Tailwind CSS
- Alpine.js
- Vite

### Testing dan tooling

- Pest PHP
- Laravel Pint
- Laravel Boost

## Persyaratan sistem

Pastikan perangkat sudah memiliki:

- PHP 8.3 atau lebih baru
- Composer
- Node.js dan npm
- Ekstensi PHP SQLite

Untuk memeriksa instalasi:

```bash
php -v
composer -V
node -v
npm -v
```

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/irfandeny/split_bill_app.git
cd split_bill_app
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Siapkan environment

Linux/macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Siapkan database

Project menggunakan SQLite secara default. Jika file database belum tersedia, buat file tersebut:

Linux/macOS:

```bash
touch database/database.sqlite
```

Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

Jalankan migrasi dan data awal:

```bash
php artisan migrate --seed
```

Konfigurasi database dapat diubah melalui `.env`. Untuk SQLite, pastikan konfigurasi berikut tersedia:

```dotenv
DB_CONNECTION=sqlite
```

### 5. Install dependency frontend dan build asset

```bash
npm install
npm run build
```

## Menjalankan aplikasi

Untuk development, jalankan server Laravel dan Vite di terminal terpisah:

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Buka [http://localhost:8000](http://localhost:8000) di browser.

## Alur penggunaan

1. Daftar akun atau masuk ke akun yang sudah ada.
2. Buat trip baru dari dashboard atau halaman **My Trips**.
3. Tambahkan semua anggota yang ikut dalam trip.
4. Tambahkan expense baru.
5. Masukkan nominal yang dibayar oleh satu atau beberapa anggota.
6. Pilih participant dan metode pembagian biaya.
7. Simpan expense untuk memperbarui ringkasan kontribusi.

### Aturan validasi expense

- Minimal ada satu payer dan satu participant.
- Total nominal seluruh payer harus sama dengan total expense.
- Untuk pembagian custom, total seluruh nominal participant harus sama dengan total expense.
- Untuk pembagian percentage, total persentase participant harus 100%.
- Anggota yang dipilih sebagai payer atau participant harus terdaftar pada trip terkait.

## Menjalankan test

Jalankan seluruh test dengan:

```bash
php artisan test
```

Atau gunakan script Composer:

```bash
composer test
```

## Struktur direktori penting

```text
app/
├── Http/Controllers/     # Controller trip, member, expense, auth, dan profil
├── Models/               # Model Trip, Expense, Member, Settlement, dan User
└── Services/             # Logika bisnis, termasuk perhitungan saldo trip

database/
├── migrations/           # Skema users, trips, members, expenses, dan settlements
└── seeders/              # Data awal aplikasi

resources/
├── css/                  # Source stylesheet Tailwind
├── js/                   # Alpine.js dan interaksi form expense
└── views/                # Halaman Blade aplikasi

routes/
├── web.php               # Route dashboard, trip, member, dan expense
└── auth.php              # Route autentikasi
```

## Catatan pengembangan

- Akses trip dibatasi kepada user yang membuat trip.
- Penghapusan trip akan menghapus data terkait melalui cascade delete database.
- Skema dan model settlement sudah disiapkan untuk pencatatan pelunasan, tetapi alur route/controller dan antarmuka settlement belum tersedia pada versi saat ini.
- Untuk perubahan skema database, buat migration baru menggunakan:

```bash
php artisan make:migration nama_migration
```

## Perintah yang sering digunakan

```bash
# Bersihkan cache aplikasi
php artisan optimize:clear

# Lihat daftar route
php artisan route:list

# Jalankan migration baru
php artisan migrate

# Reset database lalu isi ulang seeder
php artisan migrate:fresh --seed

# Format kode PHP
vendor/bin/pint

# Build asset production
npm run build
```

## Kontribusi

1. Fork repository ini.
2. Buat branch fitur baru:

   ```bash
   git checkout -b fitur/nama-fitur
   ```

3. Pastikan test dan formatter berhasil dijalankan.
4. Buat pull request dengan penjelasan perubahan yang jelas.

## Lisensi

Project ini menggunakan lisensi MIT. Lihat [LICENSE](LICENSE) jika file lisensi tersedia di repository.
