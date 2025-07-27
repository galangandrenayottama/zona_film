
# 🎬 Zona Film - Aplikasi Streaming

Zona Film adalah sebuah aplikasi streaming film berbasis Laravel yang memanfaatkan data dari TMDb API. Aplikasi ini memungkinkan pengguna untuk melihat detail film, menyimpan playlist, meninggalkan komentar, serta berlangganan paket streaming.

## Kelompok 5
- **Galang** 23.11.5412
- **Gilang** 23.11.5411
- **Sakti** 23.11.5419
- **Earlyan** 23.11.5384
- **Pandu** 23.11.5374

## 🚀 Fitur Utama

- 🔐 **Autentikasi Pengguna** (Login, Register)
- 📺 **Detail Film** dengan poster dan informasi dari TMDb
- 📜 **Komentar** pengguna pada film
- ⏱️ **Riwayat Tontonan**
- 🎞️ **Playlist** film pengguna
- 💳 **Langganan Paket** dengan metode pembayaran seperti OVO dan virtual
- 🖼️ **Upload Foto Profil**

## 🗂️ Struktur Tabel Database

Beberapa tabel penting pada database:
- `users`: Menyimpan data pengguna termasuk email, nama, foto, dan paket aktif
- `comments`: Komentar pengguna terhadap film (relasi ke `users`)
- `watch_histories`: Riwayat film yang ditonton pengguna
- `playlists`: Daftar film yang disimpan oleh pengguna
- `subscriptions`: Informasi langganan pengguna
- `personal_access_tokens`: Token untuk otentikasi API

> Database menggunakan **MariaDB** dan dapat diimpor melalui file `laravel.sql`.
> 📥 Download file database: [Klik di sini untuk mengunduh laravel.sql](https://drive.google.com/file/d/17Y6zwZbPBsOTaML4mi7IqjekEfcPBhJ5/view?usp=sharing)

## ⚙️ Instalasi

1. **Clone repositori ini**
   ```bash
   git clone https://github.com/galangandrenayottama/zona_film.git
   cd zona_film
   ```

2. **Install dependency**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Salin file environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi `.env` untuk koneksi database**
   ```env
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Import database**
   Gunakan aplikasi seperti **phpMyAdmin** atau jalankan:
   ```bash
   mysql -u root -p laravel < db.sql
   ```

6. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

## 🛠️ Dibangun Dengan

- Laravel 10+
- MariaDB
- Bootstrap
- TMDb API

## 📄 Lisensi

Proyek ini dibuat sebagai tugas pembelajaran dan bersifat open untuk pengembangan lebih lanjut.
