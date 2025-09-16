# Document Archive System (SK)

A digital archive system for managing Decision Letters (SK) with upload, preview, and download features. Built using Laravel 10+ with modern Blade interface, TailwindCSS, and Alpine.js.

## 🚀 Main Features

- **Multi-Role Authentication**: Admin, Division Members, and Guests
- **File Upload**: Support for PDF, DOC, DOCX up to 10MB
- **PDF Preview**: Direct preview in modal for PDF files
- **Division Management**: 18 divisions with user relations
- **Search & Filter**: Search by title, number, division, and year
- **Mobile Responsive**: Responsive UI for all devices
- **Drag & Drop**: Upload files with drag and drop
- **Role-based Access**: Access control based on user roles

## 📋 System Requirements

- PHP 8.1+
- Composer
- MySQL 8.0+ or other Laravel-supported databases
- Node.js & NPM
- Git

## 🛠️ Installation

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

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file and configure the database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=document_archive_sk
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets

```bash
npm run build
# or for development
npm run dev
```

### 6. Run Server

```bash
php artisan serve
```

The application will run at `http://localhost:8000`

## 👥 Dummy Accounts

After running `php artisan db:seed`, the system will create the following dummy accounts:

### Administrator
- **Email**: admin@sk.com
- **Password**: Admin1234
- **Role**: Admin (full access to all features)

### Division Member TI
- **Email**: anggota1@sk.com
- **Password**: Member1234
- **Role**: Division Member (can create and manage SK of their own division)

### Guest
- **Email**: tamu@sk.com
- **Password**: Tamu1234
- **Role**: Guest (can only view and download SK)

## 📁 Database Structure

### Main Tables
- **users**: User data with roles (admin, anggota_divisi, tamu)
- **divisions**: 18 organization divisions
- **sks**: Decision Letter data with file attachments

### Dummy Data
- **Divisions**: 18 divisions have been seeded (TI, SDM, KEU, etc.)
- **SK**: 5 dummy PDF SK samples have been seeded

## 🔐 Access Rights

### Admin
- Manage all users
- Manage all SK
- Access dashboard with complete statistics

### Division Member
- Manage SK of their own division
- View SK of other divisions
- Upload and download files

### Guest
- View SK list
- Preview and download SK
- Cannot upload or edit

## 🛠️ Technologies Used

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, TailwindCSS, Alpine.js
- **Database**: MySQL (can be replaced with PostgreSQL, SQLite, etc.)
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage (public disk)
- **Build Tool**: Vite
- **Testing**: PHPUnit

## 📝 Usage Notes

- SK files are stored in `storage/app/public/sk/`
- Maximum file size: 10MB
- Supported file formats: PDF, DOC, DOCX
- Preview only available for PDF files
- Search can be done by title, SK number, division, and year

## 🧪 Testing

Run tests with:

```bash
php artisan test
```

## 👨‍💻 Developer

This system was created by **Dede Satriya** from **Politeknik Caltex Riau**, then imported directly to this GitHub repository.

## 📄 License

This project uses the MIT license.
