# **🧾 Changelog Template Aplikasi PHP Framework CI 4**

## 📦 4.5.0 (Jan 2024)
- Perbaikan dan aktivasi modul Log Aktivitas
- Penambahan validasi tipe file upload foto user, logo, & login background
- Perbaikan bugs sub menu tidak muncul ketika sidebar collapsed
- Penambahan kontrol pada fungsi login & logout IonAuth
- Penambahan validasi server side pada number captcha
- Standarisasi tombol filter Dashboard & Daftar Pengguna
- Penambahan loader ketika proses load data Otorisasi
- Penyesuaian style ECharts & Tabulator pada dark mode
- Penambahan field input Deskripsi App & upload Background Login pada modul Setting Situs

## 📦 4.4.0 (Des 2023)
- Penambahan input number captcha pada halaman Login (client-side validation)
- Penambahan toggle password visibility pada Login, Register, Reset Password, & Ubah Password
- Hide ceklis Ingatkan Saya pada form Login
- Penambahan form validation pada form Registrasi, Reset Password, & Lupa Password
- Pengaturan judul & footer dinamis pada views auth

## 📦 4.3.0 (Okt 2023)
- Perubahan default chart library menjadi ECharts
- Aktivasi fitur session regenerate destroy
- Perbaikan bugs fitur Go To
- Perbaikan bugs filter otorisasi di PHP 8
- Perbaikan bugs select2 pada modal Bootstrap
- Penambahan slot konten modal pada view template
- Perbaikan style pada topbar & title bar
- Penambahan filter otorisasi untuk proteksi routes

## 📦 4.2.0 (Agu 2023)
- Penambahan filter otorisasi untuk proteksi routes
- Perbaikan bugs trigger delete & active row Tabulator

## 📦 4.1.0 (Jul 2023)
- Penambahan fitur switch ke dark mode
- Menghilangkan fitur error monitoring Bugsnag
- Perbaikan minor meta tag & app title
- Perbaikan bugs dropdown aksi pada Tabulator

## 🐘 4.0.0 (Mei 2023)
- Update support versi PHP ke `8.2.4`
- Update versi CodeIgniter ke `4.3.4`
- Perbaikan bugs gagal migrate database
- Penambahan template konfigurasi Docker
- Perbaikan bugs JWT

## 🐜 3.2.3 (Mar 2023)
- Update konfigurasi purge pada PostCSS

## 🐜 3.2.2 (Jan 2023)
- Penambahan validasi pada input field password

## 🐜 3.2.1 (Des 2022)
- Perbaikan bugs pagination modul Utility

## 📦 3.2.0 (Nov 2022)
- Setup error monitoring JS & PHP menggunakan Bugsnag
- Penambahan UI dummy pada Dashboard
- Migrasi modul CRUD Generator ke branch `feature/crud-generator`
- Setting warna dinamis dari database
- Menghilangkan button group Aksi jika isinya kosong
- Improvement modul Login As
- Update layout tabel Otorisasi
- Update database migrations
- Improvement konfigurasi tabulator
- Penambahan konfigurasi postcss, purgecss, & cssnano
- Perbaikan konflik modul user
- Penambahan komponen iLoader
- Penambahan konfigurasi uglifyjs
- Redesain UI error page
- Optimasi aset image dari JPG/PNG ke WEBP
- Penambahan **Kitab Template Aplikasi PHP Framework CI 4**

## 📦 3.1.0 (Okt 2022)
- Penambahan migration table view
- Penambahan fitur ambil alih user login
- Penambahan filter di modul user
- Update versi chart.js ke `3.9.1`
- Update versi ckeditor4 ke `4.20.0`
- Update versi jquery ke `3.6.1`
- Update versi sweetalert2 ke `11.6.2`
- Update versi tabulator ke `5.4.2`
- Perbaikan script init tabulator di all modul utilitas

## 🐜 3.0.1 (Sep 2022)
- Perbaikan bugs accordion Bootstrap pada tabulator
- Perbaikan bugs IonAuth logout 2x
- Perbaikan bugs name app

## 🐘 3.0.0 (Agu 2022)
- Update versi chart.js ke `3.8.2`
- Update versi DataTable ke `1.12.1`
- Penambahan konfigurasi Bootstrap form validation
- Penambahan tag base pada template
- Penambahan style form validation untuk select2
- Improvement all modul Utilitas
- Perbaikan style input color picker
- Menghapus library select2totree
- Penambahan function untuk format & unformat mata uang rupiah
- Perbaikan style header tabel
- Perbaikan bugs z-index datepicker
- Penambahan custom style input file drag & drop
- Improvement konfigurasi select2

## 📦 2.2.0 (Jul 2022)
- Update routing Setting Situs
- Perbaikan bugs upgrade versi CI
- Update versi Bootstrap ke `5.2.0`
- Penambahan fitur color customizer
- Update style header DataTable
- Penambahan konfirmasi sweetalert untuk hapus & set aktif/non aktif
- Penambahan script & konfigurasi CKEditor4
- Penambahan fitur reset tema warna default
- Penambahan toast selamat datang ketika pertama kali login
- Penambahan & konfigurasi library bootstrap-datepicker

## 🐜 2.1.4 (Mei 2022)
- Update page meta

## 🐜 2.1.3 (Mar 2022)
- Update versi chart.js ke `3.7.1`

## 🐜 2.1.2 (Feb 2022)
- Update styling select2
- Perbaikan asset url pada modul Reset Password

## 🐜 2.1.1 (Jan 2022)
- Sass improvement
- Update form Utilitas
- Update CRUD Generator

## 📦 2.1.0 (Des 2021)
- Update layout modul Otorisasi
- Update `firebase/php-jwt` jadi `dev-main`
- Improvement pengambilan data role tanpa view
- Update tipe data user pada Log Activity
- Penambahan base template custom layout 2 *(layout dengan top navigation)*

## 🐘 2.0.0 (Nov 2021)
- Update versi chart.js ke `3.6.0`
- Update versi jquery ke `3.6.0`
- Update versi tabulator ke `4.9.3`
- Penambahan CSS Bar Widget
- Update versi Bootstrap ke `5.1.3`
- Update utility Sass
- Penambahan custom layout 1

## 📦 1.8.0 (Okt 2021)
- Rollback penggunaan bundling assets menggunakan gulp.js

## 📦 1.7.0 (Sep 2021)
- Improvement metode pengambilan nama role
- Penambahan sampel penggunaan JWT

## 📦 1.6.0 (Agu 2021)
- Improvement gulp.js config
- Update versi chart.js ke `3.5.0`
- Konfigurasi bundling JavaScript

## 📦 1.5.0 (Jul 2021)
- Penambahan modul CRUD Generator
- Fix jquery-ui bundling

## 📦 1.4.0 (Jun 2021)
- Update encrypt / decrypt
- Update seeder password
- Penambahan pipeline uglify, postcss, autoprefix
- Cleansing function yang tidak terpakai

## 📦 1.3.0 (Mei 2021)
- Update timezone ke Asia/Jakarta
- Improvement app script JS
- Konfigurasi assets node_modules melalui package.json
- Optimasi assets menggunakan gulp.js
- Penambahan Sass

## 📦 1.2.0 (Apr 2021)
- Improvement template assets
- Update bahasa
- Penambahan setting profil & ubah password
- Penambahan JWT API login
- Update modul Dashboard
- Penambahan modul Log Activity

## 📦 1.1.0 (Mar 2021)
- Penambahan modul manajemen user
- Setup migration
- Penambahan modul utilitas
- Improvement konfigurasi IonAuth 4
- Update assets tabulator & select2
- Penambahan CRUD modules, roles, privilege
- Update template layout
- Penambahan modul lupa password
- Update config email

## 🚩 1.0.0 (Feb 2021)
- Initial release
- Pembuatan auth dengan IonAuth 4