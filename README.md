# Dashboard Jef — Headless API & Admin CMS

Backend Headless REST API & CMS Admin untuk platform fotografi **Jeff Lee**, dibangun menggunakan **Laravel 12**, **Laravel Breeze**, **Sanctum**, dan runtime performa tinggi **FrankenPHP (Caddy)**.

Aplikasi ini mengontrol seluruh data portofolio, artikel cerita, pengaturan banner beranda 21:9, profil fotografer, serta mengotomatisasi pengiriman notifikasi reservasi pemotretan (*booking system*) ke email dan WhatsApp.

---

## 🚀 Fitur Utama

1. **Public Profile & 21:9 Hero Studio (`/admin/profile`)**:
   * Pengaturan profil fotografer (Nama, Title, Bio, Email notifikasi, No. WhatsApp internasional, Kota lokasi, Akun Instagram & Facebook).
   * **Hero Banner Studio:** Unggah banner kustom rasio lebar 21:9 atau gunakan foto portofolio *Highlight*.
   * **Rule-of-Thirds Focal Point Slider:** Penyesuaian titik fokus vertikal (0% - 100%) dengan pratinjau grid sepertiga real-time agar subjek foto tidak terpotong di layar HP maupun desktop.
2. **Portfolio Management (`/admin/portfolios`)**:
   * Organisasi karya berdasarkan **11 tema fotografi resmi**:
     * *Family, Portrait, Couple, Newborn, Work Documentary, Animal, Plant, Sports, Event, Celebration, Travel*.
   * Upload foto sampul (*thumbnail*) & seri galeri multi-foto (*multi-image gallery*).
   * Pengelolaan foto seri galeri secara individual (hapus per foto tanpa menimpa galeri lain).
   * Toggle status *Publish* & *Highlight* instan.
   * Tempat Sampah ganda: Soft Delete, Restore, dan Force Delete (*Trash System*).
3. **Articles & Reflections (`/admin/articles`)**:
   * Manajemen esai visual dan cerita di balik foto.
   * Auto-generated slug, upload cover image, ringkasan (*excerpt*), dan sanitasi konten aman XSS.
4. **Bookings & 1-Click WhatsApp (`/admin/bookings`)**:
   * Menampung reservasi pemotretan dari calon klien di frontend Nuxt 3.
   * Manajemen status booking (*pending, confirmed, completed, canceled*) dan catatan internal (*Admin Notes*).
   * **1-Click WhatsApp Action:** Tombol hijau langsung membuka chat WhatsApp ke klien dengan pesan pembuka otomatis.
   * Modal konfirmasi hapus berbasis Alpine.js dengan dukungan pemulihan Trash.
5. **Dual-Channel Notification Engine (`BookingNotificationService`)**:
   * Mengambil target penerima secara dinamis dari pengaturan `PhotographerProfile`.
   * **Cloud-Native HTTPS Email API:** Mendukung driver **Resend API** (`resend`) dan **Brevo API** (`brevo`) melalui HTTPS port 443 — kebal terhadap blokir outbound port SMTP (25, 465, 587) pada platform hosting gratis seperti Render Free Tier.
   * Fail-fast socket timeout 5 detik (`MAIL_TIMEOUT=5`) untuk mencegah fatal timeout 30 detik pada environment serverless.
   * Template email notifikasi HTML responsif (`emails.bookings.new`) dilengkapi tombol langsung WhatsApp klien dan akses dashboard.
6. **Baterai Pengujian Otomatis (Test Suite)**:
   * **60 Automated Feature Tests** (224 assertions) mencakup autentikasi, manajemen portofolio, artikel, booking, public profile API, dan sistem notifikasi (`php artisan test`).

---

## 📡 Endpoint REST API Publik

| Method | Endpoint | Query / Body | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/up` | - | Health check status untuk keep-alive cron & uptime monitor |
| `GET` | `/api/profile` | - | Data profil fotografer, hero banner 21:9, focal point, kontak, & SEO |
| `GET` | `/api/portfolios` | `?category=Family` | Daftar portofolio terpublikasi (opsional filter tema) |
| `GET` | `/api/portfolios/{slug}` | - | Detail karya portofolio beserta array seri galeri lengkap |
| `GET` | `/api/articles` | - | Daftar artikel cerita terpublikasi |
| `GET` | `/api/articles/{slug}` | - | Detail artikel lengkap berdasarkan slug |
| `POST` | `/api/bookings` | JSON Body | Mengirim formulir reservasi klien & memicu notifikasi |

### Format Payload POST `/api/bookings`:
```json
{
  "name": "Sarah Jenkins",
  "email": "sarah.j@example.com",
  "phone": "+61412345678",
  "package": "Family",
  "location": "Centennial Park, Sydney",
  "booking_date": "2026-12-05",
  "message": "Prefer golden hour afternoon shoot"
}
```

---

## ☁️ Arsitektur Produksi (Zero-Budget Cloud)

* **Web Service:** [Render.com](https://render.com) Free Tier (Docker FrankenPHP, PHP 8.3).
* **Database:** [TiDB Cloud Serverless](https://tidbcloud.com) (MySQL 8 protocol, auto-scaling, SSL encrypted).
* **Email API:** [Resend](https://resend.com) atau [Brevo](https://brevo.com) via HTTPS REST API (Port 443).
* **Storage:** [Cloudflare R2](https://www.cloudflare.com/developer-platform/r2/) (S3-compatible object storage) / Local Storage Link.
* **Keep-Alive Cron:** [cron-job.org](https://cron-job.org) melakukan ping HTTP GET ke `https://dashboard-jef.onrender.com/up` setiap 10-14 menit untuk mencegah container tertidur (*prevent sleep*).

---

## 🛠️ Local Development

### 1. Prasyarat
* PHP >= 8.2 (Disarankan PHP 8.3)
* Composer
* MySQL Server (via DBngin / XAMPP / Laragon)

### 2. Instalasi & Environment
```bash
git clone https://github.com/yodi-dev/dashboard-jef.git
cd dashboard-jef
composer install
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database Lokal (`.env`)
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dashboard_jef
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeder Data
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```
> **Catatan Seeder:** `DemoDataSeeder` akan otomatis mengisi akun admin, profil fotografer, **11 tema karya portofolio lengkap** beserta galeri foto, dan 4 artikel cerita refleksi.

### 5. Menjalankan Uji Otomatis
```bash
php artisan test
```
Seluruh 60 skenario pengujian akan dieksekusi untuk memastikan integritas aplikasi.

### 6. Menjalankan Server Lokal
```bash
php artisan serve
```
Dashboard dapat diakses di `http://127.0.0.1:8000/login`.

---

## ⚙️ Konfigurasi Produksi di Render (`.env`)

Saat mendeploy ke Render, tambahkan environment variables berikut pada Render Dashboard:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dashboard-jef.onrender.com

# Database TiDB Cloud Serverless (SSL Wajib Aktif)
DB_CONNECTION=mysql
DB_HOST=<tidb-gateway-host>
DB_PORT=4000
DB_DATABASE=dashboard_jef
DB_USERNAME=<tidb-user>
DB_PASSWORD=<tidb-password>
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt

# Email Notifikasi via HTTPS API (Render Free Friendly)
MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=onboarding@resend.dev
MAIL_FROM_NAME="Jef Lee Photography"
MAIL_TIMEOUT=5

# Keep-Alive & Health Check
KEEP_ALIVE_URL=https://dashboard-jef.onrender.com/up
```

---

## 📖 Panduan Penggunaan untuk Klien
Panduan operasional lengkap bagi fotografer (cara upload foto, setting banner 21:9, tindak lanjut booking dengan 1-click WhatsApp) tersedia pada dokumen:
👉 **[HANDOVER_MANUAL.md](./HANDOVER_MANUAL.md)**

---

## 📄 Lisensi
Hak Cipta © 2026 Jeff Lee Photography. Dikembangkan oleh [awanbeo](https://awanbeo.my.id) & yodi-dev.
