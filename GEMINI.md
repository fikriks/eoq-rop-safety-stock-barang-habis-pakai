# EOQ, ROP, and Safety Stock for Consumables

## Project Context
- **Primary Requirements:** Lihat [PRD.md](PRD.md) untuk rincian fitur, metodologi perhitungan (EOQ/ROP/SS), dan struktur database.
- **Current Progress:** Lihat [PROGRESS.md](PROGRESS.md) untuk riwayat pembaruan, perubahan UI/UX, dan daftar fitur yang sudah selesai.
- **Location:** Kantor Cabang Dinas Pendidikan Wilayah X Provinsi Jawa Barat.

## Project Overview

This project is a web-based inventory management system built with **CodeIgniter 4**. Its primary goal is to manage consumables (*barang habis pakai*) by implementing several inventory control methodologies:
- **EOQ (Economic Order Quantity):** To determine the optimal order quantity that minimizes total inventory costs.
- **ROP (Reorder Point):** To identify the inventory level at which a new order should be placed.
- **Safety Stock:** To maintain a buffer to prevent stockouts during lead time or due to demand fluctuations.

The project follows the standard CodeIgniter 4 architecture (MVC) and uses Composer for dependency management.

### Key Technologies
- **Framework:** CodeIgniter 4.x
- **UI Framework:** Bootstrap 5
- **Language:** PHP 8.2+
- **Database:** MySQL/MariaDB (default recommendation for CI4 projects)
- **Testing:** PHPUnit

## Building and Running

### Prerequisites
- PHP 8.2 or higher with `intl`, `mbstring`, `json`, `mysqlnd`, and `libcurl` extensions enabled.
- Composer.

### Initial Setup
1.  **Install Dependencies:**
    ```bash
    composer install
    ```
2.  **Environment Configuration:**
    Copy the example `env` file to `.env`:
    ```bash
    cp env .env
    ```
    Configure your database settings and `app.baseURL` in the `.env` file.
3.  **Database Migrations:**
    (Once migrations are implemented)
    ```bash
    php spark migrate
    ```

### Running the Application
Use the built-in development server:
```bash
php spark serve
```
The application will be accessible at `http://localhost:8080`.

### Running Tests
Execute the test suite using PHPUnit:
```bash
composer test
```
Or via spark:
```bash
php spark test
```

## Development Conventions

### Naming Conventions
- **Controllers:** Harus menggunakan suffix `Controller` (contoh: `BarangController.php`, `HomeController.php`).
- **Models:** Harus menggunakan suffix `Model` (contoh: `BarangModel.php`, `UserModel.php`).
- **Namespaces:** Gunakan `App\Controllers` dan `App\Models`.

### Architecture
- **Models:** Located in `app/Models/`. Should extend `CodeIgniter\Model`. Use them for database interactions and business logic related to data.
- **Views:** Located in `app/Views/`. Use PHP or CodeIgniter's View cells for the UI.
- **Controllers:** Located in `app/Controllers/`. Should extend `BaseController`. Keep them thin, delegating logic to Models or Libraries.
- **Config:** Located in `app/Config/`. All application settings should be handled here.
- **Migrations:** Located in `app/Database/Migrations/`. Use them for all schema changes.

### Styling
- **CSS Framework:** Bootstrap 5.
- **Color Schema:** Black & White (Hitam Putih) dengan kontras tinggi.
- **Tipografi:** **Nunito** (Google Fonts).
- **Layouts:** Gunakan CodeIgniter 4 View Layouts (`app/Views/layout.php`) untuk menjaga konsistensi. Hindari penggunaan border-radius (gunakan sudut tajam) untuk kesan minimalis/brutalist.

### Coding Style
- Follow **PSR-12** coding standards.
- Use **PSR-4** for autoloading (configured in `composer.json`).
- Ensure all new features are accompanied by tests in the `tests/` directory.

### Key Commands
- `php spark make:controller <Name>Controller`: Create a new controller with suffix.
- `php spark make:model <Name>Model`: Create a new model with suffix.
- `php spark make:migration <Name>`: Create a new database migration.
- `php spark migrate`: Run pending migrations.
- `php spark db:seed <Name>`: Run a specific seeder.
