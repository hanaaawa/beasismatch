# 🎓 BeasisMatch

> Smart Scholarship Recommendation & Matching Platform

BeasisMatch adalah platform berbasis web yang membantu mahasiswa menemukan beasiswa yang paling sesuai berdasarkan profil akademik, preferensi, dan data personal secara real-time menggunakan sistem rekomendasi terstruktur.

---

## 📌 Key Features

### 👤 User System
- Register & Login (Email + Google OAuth)
- Profil akademik pengguna
- Session-based authentication

### 🎯 Recommendation Engine
- Matching beasiswa berbasis profil user
- Filtering berdasarkan kriteria akademik
- Ranking rekomendasi otomatis

### 📚 Scholarship Management
- CRUD data beasiswa
- Detail informasi beasiswa
- Kategori & filter dinamis

### 💬 Community Forum
- Forum diskusi global
- Tanya jawab antar user
- Interaksi komentar & engagement

### 🛠 Admin Panel
- Dashboard admin (Filament)
- Manajemen user & beasiswa
- Monitoring sistem

---

## 🧠 System Concept

BeasisMatch menggunakan pendekatan:

- Rule-based filtering (profil vs kriteria beasiswa)
- Relational database matching
- Real-time query-based recommendation

---

## 🧱 Tech Stack

| Layer | Technology |
|------|------------|
| Backend | Laravel 11 |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL / MariaDB |
| Auth | Laravel Auth + Google OAuth |
| Admin Panel | Filament |
| DevOps | Docker (Nginx, PHP, DB) |

---

## ⚙️ System Architecture


---

## 🚀 Installation

### 1. Clone Project
```bash
git clone https://github.com/USERNAME/beasismatch.git
cd beasismatch/src

2. Install Dependencies
composer install
npm install && npm run build
3. Environment Setup
cp .env.example .env
php artisan key:generate
4. Database Migration
php artisan migrate --seed
5. Run Project
php artisan serve
🐳 Docker Setup
docker compose up -d --build
🔑 Google OAuth Configuration
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback

⚠️ Pastikan redirect URI sesuai dengan Google Cloud Console

🧪 Demo Account
Email: admin@admin.com
Password: (sesuai seeder)
📁 Project Structure
app/
 ├── Http/
 ├── Models/
 ├── Services/
database/
resources/
routes/
📊 Project Highlights
Real-world Laravel architecture
OAuth integration (Google)
Modular system design
Forum-based community feature
Admin dashboard system
⚠️ Notes
.env tidak termasuk repository
Pastikan database aktif sebelum migrate
OAuth hanya bekerja jika domain & redirect URI valid
👨‍💻 Developer

BeasisMatch Project (UAS Project)
Built for academic + portfolio demonstration

⭐ Purpose

Project ini dibuat untuk:

UAS Web Programming
Portfolio Laravel Developer
Demonstrasi sistem rekomendasi sederhana
