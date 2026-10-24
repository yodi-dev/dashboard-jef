# Dashboard Jef — Headless API & Admin CMS

Backend Headless API & CMS Admin untuk platform fotografi **Jeff Lee**, dibangun dengan **Laravel 12**, **Laravel Breeze**, dan **Sanctum**.

Aplikasi ini bertindak sebagai pusat manajemen data (*content management system*) yang menyuplai data ke frontend [portfolio-jeff](https://github.com/yodi-dev/portfolio-jeff) melalui REST API.

---

## 🚀 Fitur Utama

1. **Portfolio Management (`/admin/portfolios`)**:
   * Mendukung organisasi galeri berdasarkan **11 tema fotografi**:
     * *Family, Portrait, Couple, Newborn, Work Documentary, Animal, Plant, Sports, Event, Celebration, Travel*.
   * Upload thumbnail foto & multi-image gallery.
   * Toggle status *Publish* & *Highlight* (Landing Page) instan.
   * Fitur Soft Delete & Restore (Trash system).
2. **Articles / Stories Management (`/admin/articles`)**:
   * Manajemen artikel dan refleksi foto.
   * Auto-generated slug, upload cover image, konten cerita, dan status publish.
3. **Bookings Management (`/admin/bookings`)**:
   * Menerima reservasi sesi foto dari calon klien di frontend.
   * Otomatisasi pengiriman email notifikasi pemesanan baru (`Mail::to(...)`).
   * Manajemen status booking (*pending, confirmed, completed, canceled*).
4. **Public REST API & CORS**:
   * Endpoint publik yang aman dan siap dikonsumsi oleh Nuxt 3.

---

## 📡 Dokumentasi Endpoint REST API

| Method | Endpoint | Query Param | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/portfolios` | `?category=Family` | Mengambil seluruh portofolio publik (opsional filter tema) |
| `GET` | `/api/portfolios/{slug}` | - | Mengambil detail portofolio & galeri lengkap |
| `GET` | `/api/articles` | - | Mengambil daftar artikel blog publik |
| `GET` | `/api/articles/{slug}` | - | Mengambil konten artikel lengkap |
| `POST` | `/api/bookings` | Body JSON | Mengirim data booking photoshoot dari klien |

### Format Payload POST `/api/bookings`:
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "+6281234567890",
  "package": "Family",
  "location": "Sydney Botanic Gardens",
  "booking_date": "2026-11-15",
  "message": "Prefer golden hour shoot"
}
```

---

## 🛠️ Local Development

### 1. Prasyarat
* PHP >= 8.2 (Disarankan PHP 8.3)
* Composer
* MySQL Server (via DBngin / XAMPP / Laragon)

### 2. Konfigurasi Environment (`.env`)
Pastikan konfigurasi database di file `.env` sudah sesuai:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dashboard_jef
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Storage Link
```bash
php artisan migrate
php artisan storage:link
```

### 4. Menjalankan Server
```bash
php artisan serve
```
Backend akan berjalan di `http://127.0.0.1:8000` (atau lewat Laravel Herd di `http://dashboard-jef.test`).

---

## 📄 Lisensi
Hak Cipta © 2026 Jeff Photography. Dikembangkan oleh [awanbeo](https://awanbeo.my.id) & yodi-dev.
