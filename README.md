# 🎓 BeasisMatch

<div align="center">

### Smart Scholarship Recommendation & Matching Platform

Platform rekomendasi beasiswa berbasis web yang membantu mahasiswa menemukan beasiswa sesuai profil akademik dan kriteria pendaftaran.

</div>

---

## 📌 Tentang BeasisMatch

**BeasisMatch** adalah platform web berbasis Laravel yang dirancang untuk membantu mahasiswa mencari, menyaring, dan mencocokkan beasiswa berdasarkan profil akademik pengguna.

Pengguna dapat melengkapi profil akademik, melihat informasi beasiswa, memperoleh rekomendasi beasiswa, serta berinteraksi melalui forum diskusi. Sistem juga menyediakan dashboard admin untuk mengelola pengguna dan data beasiswa.

---

## 🚀 Fitur Utama

### 👤 Autentikasi

- Registrasi menggunakan email
- Login menggunakan email
- Login menggunakan Google OAuth
- Session-based authentication
- Logout pengguna

### 🎯 Sistem Rekomendasi

- Pencocokan beasiswa berdasarkan profil pengguna
- Penyaringan berdasarkan kriteria akademik
- Rekomendasi beasiswa secara otomatis
- Informasi tingkat kecocokan pengguna dengan beasiswa

### 📚 Manajemen Beasiswa

- Menampilkan daftar beasiswa
- Menampilkan detail beasiswa
- Pencarian dan filter beasiswa
- Kategori beasiswa
- Pengelolaan data beasiswa melalui proses CRUD

### 💬 Forum Diskusi

- Forum diskusi untuk seluruh pengguna
- Tanya jawab antar mahasiswa
- Komentar pada setiap diskusi
- Interaksi antar pengguna

### 🛠️ Dashboard Admin

- Dashboard admin menggunakan Filament
- Manajemen data pengguna
- Manajemen data beasiswa
- Manajemen kategori beasiswa
- Pemantauan data melalui admin panel

---

## ⚙️ Alur Sistem

1. Pengguna melakukan registrasi atau login.
2. Pengguna melengkapi profil dan data akademik.
3. Sistem membandingkan profil pengguna dengan kriteria beasiswa.
4. Sistem menghitung tingkat kecocokan beasiswa.
5. Hasil rekomendasi ditampilkan kepada pengguna.
6. Pengguna dapat membuka detail beasiswa dan mengikuti forum diskusi.

---

## 🧱 Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| Laravel 11 | Framework backend |
| PHP 8.3 | Bahasa pemrograman backend |
| MySQL / MariaDB | Database |
| Tailwind CSS | Styling antarmuka |
| Filament | Dashboard dan panel admin |
| Laravel Socialite | Google OAuth |
| Docker | Container aplikasi |
| Nginx | Web server |
| JavaScript | Interaksi antarmuka |
| Vite | Build tool frontend |

---

## 📂 Struktur Utama Project

```text
beasismatch/
├── db/                  # Konfigurasi database
├── docs/                # Dokumentasi project
├── nginx/               # Konfigurasi Nginx
├── php/                 # Konfigurasi PHP
├── public/              # File publik
├── src/                 # Source code aplikasi Laravel
├── docker-compose.yml   # Konfigurasi Docker
└── README.md            # Dokumentasi repository
