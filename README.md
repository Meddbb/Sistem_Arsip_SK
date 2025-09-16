# Sistem Arsip Surat Keputusan (SK)

Sistem arsip digital untuk mengelola Surat Keputusan (SK) dengan fitur upload, preview, dan download. Dibangun menggunakan Laravel 10+ dengan antarmuka modern berbasis Blade, TailwindCSS, dan Alpine.js.

## 🚀 Fitur Utama

- **Autentikasi Multi-Role**: Admin, Anggota Divisi, dan Tamu
- **Upload File**: Dukungan PDF, DOC, DOCX hingga 10MB
- **Preview PDF**: Preview langsung dalam modal untuk file PDF
- **Manajemen Divisi**: 18 divisi dengan relasi user
- **Search & Filter**: Pencarian berdasarkan judul, nomor, divisi, dan tahun
- **Mobile Responsive**: UI yang responsif untuk semua perangkat
- **Drag & Drop**: Upload file dengan drag and drop
- **Role-based Access**: Kontrol akses berdasarkan peran pengguna
- **Dashboard**: Statistik dan ringkasan data
- **Manajemen User**: CRUD untuk pengguna (khusus admin)
- **Manajemen SK**: CRUD untuk Surat Keputusan dengan validasi role

## 📋 Persyaratan Sistem

- PHP 8.1+
- Composer
- MySQL 8.0+ atau database lain yang didukung Laravel
- Node.js & NPM
- Git

## 🛠️ Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd sistem-arsip-sk
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan konfigurasikan database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_arsip_sk
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 6. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👥 Akun Dummy

Setelah menjalankan `php artisan db:seed`, sistem akan membuat akun dummy berikut:

### Administrator
- **Email**: admin@sk.com
- **Password**: Admin1234
- **Role**: Admin (akses penuh ke semua fitur)

### Anggota Divisi TI
- **Email**: anggota1@sk.com
- **Password**: Member1234
- **Role**: Anggota Divisi (dapat membuat dan mengelola SK divisi sendiri)

### Tamu
- **Email**: tamu@sk.com
- **Password**: Tamu1234
- **Role**: Tamu (hanya dapat melihat dan mendownload SK)

## 📁 Struktur Database

### Tabel Utama
- **users**: Data pengguna dengan role (admin, anggota_divisi, tamu)
- **divisions**: 18 divisi organisasi
- **sks**: Data Surat Keputusan dengan file attachment

### Data Dummy
- **Divisi**: 18 divisi telah di-seed (TI, SDM, KEU, dll.)
- **SK**: 5 contoh SK PDF dummy telah di-seed

## 🔐 Hak Akses

### Admin
- Mengelola semua pengguna
- Mengelola semua SK
- Mengakses dashboard dengan statistik lengkap

### Anggota Divisi
- Mengelola SK divisi sendiri
- Melihat SK divisi lain
- Mengupload dan mendownload file

### Tamu
- Melihat daftar SK
- Preview dan download SK
- Tidak dapat mengupload atau mengedit

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, TailwindCSS, Alpine.js
- **Database**: MySQL (dapat diganti dengan PostgreSQL, SQLite, dll.)
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage (public disk)
- **Build Tool**: Vite
- **Testing**: PHPUnit

## 📝 Catatan Penggunaan

- File SK disimpan di `storage/app/public/sk/`
- Maksimal ukuran file: 10MB
- Format file yang didukung: PDF, DOC, DOCX
- Preview hanya tersedia untuk file PDF
- Search dapat dilakukan berdasarkan judul, nomor SK, divisi, dan tahun

## 🧪 Testing

Jalankan test dengan:

```bash
php artisan test
```

## 👨‍💻 Pengembang

Sistem ini dibuat oleh **Dede Satriya** dari **Politeknik Caltex Riau**, kemudian diimpor langsung ke GitHub repositori ini.

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT.
