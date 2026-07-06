# 🎓 BeasisMatch

> Smart Scholarship Recommendation & Matching Platform

BeasisMatch adalah platform web berbasis Laravel yang membantu mahasiswa menemukan dan mencocokkan beasiswa sesuai profil akademik secara otomatis dan real-time.

---

## 🚀 Features

### 👤 Authentication
- Login & Register (Email)
- Login dengan Google OAuth
- Session-based authentication

### 🎯 Recommendation System
- Matching beasiswa berdasarkan profil user
- Filtering berdasarkan kriteria akademik
- Rekomendasi otomatis

### 📚 Scholarship Management
- CRUD data beasiswa
- Detail informasi beasiswa
- Kategori dan filter

### 💬 Forum Diskusi
- Forum global semua user
- Tanya jawab antar mahasiswa
- Komentar & interaksi

### 🛠 Admin Panel
- Dashboard admin (Filament)
- Manajemen user
- Manajemen data beasiswa

---

## 🧱 Tech Stack

- Laravel 11
- PHP 8.3
- MySQL / MariaDB
- Tailwind CSS
- Filament Admin
- Google OAuth (Socialite)
- Docker (Nginx + PHP + DB)

---

## ⚙️ System Overview

User melakukan login → mengisi profil → sistem mencocokkan dengan database beasiswa → hasil rekomendasi ditampilkan secara real-time.

---

## 🚀 Installation Guide

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/beasismatch.git
cd beasismatch/src
