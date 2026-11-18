# Panduan Penggunaan Dashboard Admin (Handover Manual)
### Platform Portofolio & Booking Fotografi — Jeff Lee

Dokumen ini adalah panduan praktis bagi **Jeff Lee** (atau pengelola website) untuk mengelola portofolio, menulis cerita di balik foto, mengatur banner beranda, serta menindaklanjuti reservasi pemotretan yang masuk dari klien.

---

## 📌 Daftar Isi
1. [Akses & Login Admin](#1-akses--login-admin)
2. [Pengaturan Profil & Hero Banner (Beranda)](#2-pengaturan-profil--hero-banner-beranda)
3. [Mengelola Karya Portofolio (11 Kategori)](#3-mengelola-karya-portofolio-11-kategori)
4. [Menulis Cerita & Kisah Foto (Writing / Stories)](#4-menulis-cerita--kisah-foto-writing--stories)
5. [Menangani Reservasi Masuk (Bookings) & 1-Click WhatsApp](#5-menangani-reservasi-masuk-bookings--1-click-whatsapp)
6. [Sistem Tempat Sampah (Trash & Restore)](#6-sistem-tempat-sampah-trash--restore)
7. [Tips Optimasi Foto & Pemeliharaan Cloud](#7-tips-optimasi-foto--pemeliharaan-cloud)

---

## 1. Akses & Login Admin

* **URL Dashboard Admin:** `https://dashboard-jef.onrender.com/login` (atau `http://127.0.0.1:8000/login` pada komputer lokal).
* **Alamat Website Publik:** `https://portfolio-jeff.pages.dev` (atau domain kustom yang terhubung).

### Langkah Login:
1. Masukkan alamat email admin terdaftar dan password Anda.
2. Centang **"Remember me"** agar sesi login Anda tetap tersimpan.
3. Klik tombol **Log in**.
4. Jika ingin mengubah kata sandi atau email login, klik nama akun Anda di pojok kanan atas ➔ pilih **Profile**.

> [!TIP]
> Jika server sedang dalam mode hemat daya (cold-start), halaman login mungkin memerlukan waktu ~20-30 detik pada percobaan pertama. Setelah terbuka, sistem akan berjalan normal dan responsif.

---

## 2. Pengaturan Profil & Hero Banner (Beranda)

Buka menu navigasi atas: **Public Profile** (`/admin/profile`).

Halaman ini mengontrol informasi publik yang tampil di seluruh website frontend Anda:

### A. Informasi Personal & Kontak
* **Display Name:** Nama publik yang ditampilkan (misal: `Jeff Lee`).
* **Title / Subheading:** Slogan atau profesi Anda (misal: `Visual Storyteller & Portraitist`).
* **Bio / Story:** Narasi singkat filosofi fotografi yang tampil pada halaman *About* dan cuplikan *Homepage*.
* **Notification Email:** Alamat email Anda untuk menerima notifikasi otomatis setiap kali ada klien yang mengisi form booking.
* **WhatsApp / Phone Number:** Nomor WhatsApp Anda menggunakan format internasional (contoh: `+61412345678` untuk Australia, atau `+6281234567890` untuk Indonesia).
* **Location:** Kota/wilayah domisili layanan Anda (contoh: `Sydney, NSW, Australia`).
* **Social Media:** Akun Instagram dan Facebook publik Anda.

### B. Pengaturan Hero Banner 21:9 & Focal Point
Di bagian bawah halaman profil, Anda dapat mengatur foto utama yang muncul pertama kali saat pengunjung membuka website:
* **Gunakan Portofolio Highlight:** Jika dicentang, beranda akan otomatis mengambil foto portofolio terbaru yang Anda tandai sebagai *Highlight*.
* **Gunakan Custom Banner:** Jika Anda ingin memasang banner foto spesifik (misal: banner promo musiman, foto landscape khusus):
  1. Unggah foto resolusi tinggi (rasio lebar disarankan 21:9 atau minimal 1920x820 pixel).
  2. **Rule-of-Thirds Focal Point Slider:** Geser slider vertikal (0% - 100%) untuk menentukan titik fokus foto. Kotak preview akan langsung memperlihatkan grid sepertiga agar wajah atau objek utama tidak terpotong saat dibuka di layar HP maupun laptop.
  3. Klik **Save Profile Changes**.

---

## 3. Mengelola Karya Portofolio (11 Kategori)

Buka menu **Portfolios** (`/admin/portfolios`).

Semua foto di website dikelompokkan secara teratur ke dalam **11 tema**:
> **Family**, **Portrait**, **Couple**, **Newborn**, **Work Documentary**, **Animal**, **Plant**, **Sports**, **Event**, **Celebration**, **Travel**.

### Menambah Portofolio Baru:
1. Klik tombol **+ New Portfolio** di kanan atas.
2. Isi formulir:
   * **Title:** Judul karya atau nama sesi pemotretan (contoh: *Whispers of the Coast*).
   * **Category:** Pilih salah satu dari 11 tema yang sesuai.
   * **Description:** Cerita atau catatan teknis/lokasi di balik pemotretan ini.
   * **Cover Photo / Thumbnail:** Foto utama yang menjadi sampul kartu galeri.
   * **Gallery Photos (Opsional):** Unggah beberapa foto sekaligus untuk dijadikan galeri seri pada halaman detail karya (`/works/[slug]`).
   * **Status Published:** Centang agar karya langsung tampil untuk pengunjung website.
   * **Status Highlight:** Centang jika Anda ingin karya ini dipajang di grid kurasi beranda utama.
3. Klik **Save Portfolio**.

---

## 4. Menulis Cerita & Kisah Foto (Writing / Stories)

Buka menu **Articles** (`/admin/articles`).

Bagian ini dirancang untuk membagikan refleksi pemikiran, esai visual, atau artikel *behind-the-scenes*.

### Menulis Artikel Baru:
1. Klik **+ New Article**.
2. **Title:** Judul tulisan. URL (*slug*) akan dibuatkan otomatis.
3. **Cover Image:** Foto sampul artikel.
4. **Excerpt:** 1-2 kalimat ringkasan yang menarik minat baca pengunjung.
5. **Content:** Teks lengkap cerita Anda (mendukung paragraf rapi dan pemformatan teks).
6. Centang **Published** bila sudah siap dibaca publik, lalu klik **Save Article**.

---

## 5. Menangani Reservasi Masuk (Bookings) & 1-Click WhatsApp

Buka menu **Bookings** (`/admin/bookings`).

Setiap kali calon klien memesan sesi pemotretan melalui form di website:
1. Sistem mengirimkan **Email Notifikasi Otomatis** ke email Anda berisi rincian: nama klien, paket yang dipilih, nomor WhatsApp klien, tanggal sesi, lokasi, dan pesan khusus.
2. Di dalam email dan dashboard admin, tersedia tombol hijau **"Chat with Client on WhatsApp"**.

### Langkah Menindaklanjuti:
1. Pada tabel booking, klik **View / Edit** pada data klien.
2. Klik tombol hijau **Chat via WhatsApp**:
   * Komputer/HP Anda akan langsung membuka aplikasi WhatsApp menuju nomor telepon klien tanpa perlu menyimpan nomornya terlebih dahulu di kontak.
   * Pesan pembuka ramah sudah terisi otomatis (contoh: *"Halo [Nama Klien], terima kasih sudah memesan sesi foto [Paket]..."*).
3. Ubah status pemesanan sesuai perkembangan:
   * **Pending:** Baru masuk, belum dikonfirmasi.
   * **Confirmed:** Jadwal sudah disepakati bersama klien.
   * **Completed:** Pemotretan dan penyerahan foto sudah selesai.
   * **Canceled:** Sesi dibatalkan.
4. Tulis catatan pribadi pada kolom **Admin Notes** (misal: *"Klien meminta warna hangat, DP 50% sudah diterima"*). Catatan ini hanya bisa dilihat oleh admin.
5. Klik **Update Booking**.

---

## 6. Sistem Tempat Sampah (Trash & Restore)

Untuk mencegah kehilangan data berharga akibat salah klik, sistem dilengkapi dengan pengaman ganda:
* Saat Anda menghapus portofolio, artikel, atau booking, data tidak langsung hilang permanen, melainkan dipindahkan ke **Trash (Tempat Sampah)**.
* **Untuk Memulihkan Data:** Klik tab **Trash** di atas tabel ➔ klik **Restore** pada item yang ingin dikembalikan.
* **Untuk Menghapus Permanen:** Masuk ke tab **Trash** ➔ klik **Force Delete** (aksi ini tidak dapat dibatalkan).

---

## 7. Tips Optimasi Foto & Pemeliharaan Cloud

Platform ini dibangun dengan arsitektur cloud performa tinggi tanpa biaya bulanan (*Zero-Budget Architecture*):
* **Format Foto Terbaik:** Gunakan format JPG/JPEG atau WebP berorientasi sRGB.
* **Dimensi yang Disarankan:**
  * Foto Lanskap / Hero: Lebar 1920px hingga 2560px.
  * Foto Portrait / Detail: Lebar 1200px hingga 1600px.
* **Ukuran File:** Usahakan file foto berada di kisaran **300 KB – 900 KB** per gambar. Anda bisa menggunakan alat kompresi gratis seperti [TinyJPG / TinyPNG](https://tinypng.com) atau fitur export *Quality 80%* di Lightroom/Photoshop. Foto yang teroptimasi akan membuat galeri terbuka seketika bahkan pada koneksi seluler klien yang lambat.
* **Keep-Alive Server Otomatis:** Sistem sudah dihubungkan dengan pemantau otomatis yang mengirimkan sinyal setiap 10-14 menit agar server tidak tertidur di jam sibuk kerja.

---

*Hak Cipta © 2026 Jeff Lee Photography. Sistem dikembangkan oleh tim engineering Antigravity.*
