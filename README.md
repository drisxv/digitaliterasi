<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>

# Sistem Perpustakaan Digital

Aplikasi ini merupakan sistem perpustakaan digital berbasis web yang memungkinkan pengguna untuk melihat, meminjam, membaca, dan memberikan ulasan terhadap buku secara online. Sistem ini memiliki tiga jenis pengguna utama yaitu **Pengguna**, **Petugas**, dan **Admin**, yang masing-masing memiliki hak akses berbeda.

---

# Dokumentasi

Dokumentasi lengkap aplikasi dapat diunduh melalui link berikut:

* 📄 [Download Dokumentasi Aplikasi](unfinished_dokumentasi.docx)

---

# Fitur Aplikasi

## 1. Pengguna

Pengguna merupakan user umum yang dapat menggunakan sistem perpustakaan untuk mencari dan meminjam buku.

### Alur Pengguna

1. Pengguna melakukan **registrasi** untuk membuat akun.
2. Setelah berhasil registrasi, pengguna dapat **login** ke dalam sistem.
3. Setelah login, pengguna diarahkan ke **halaman daftar buku**.
4. Pengguna dapat:

   * Melihat daftar buku
   * Mengklik salah satu buku untuk melihat **detail buku**
5. Pada halaman **detail buku**, pengguna dapat:

   * Menambahkan buku ke **favorit**
   * Menentukan **tanggal peminjaman**
   * Meminjam buku
6. Setelah meminjam buku, pengguna dapat:

   * **Membaca isi buku**
   * Melihat daftar **peminjaman**
7. Pengguna dapat **mengembalikan buku** melalui:

   * Halaman detail buku
   * Halaman daftar peminjaman
8. Status pengembalian buku:

   * **Dikembalikan** → jika dikembalikan sebelum batas waktu
   * **Telat Mengembalikan** → jika melewati batas waktu pengembalian
9. Setelah meminjam buku, pengguna juga dapat **memberikan ulasan** terhadap buku tersebut.

---

## 2. Petugas

Petugas adalah pengguna yang bertugas untuk mengelola data buku dan kategori.

### Alur Petugas

1. Petugas **login menggunakan akun yang dibuat oleh admin**.
2. Setelah login, petugas dapat mengakses fitur berikut:

### Kelola Kategori

* Menambah kategori buku
* Mengedit kategori buku
* Menghapus kategori buku

### Kelola Buku

* Menambah buku
* Mengedit buku
* Menghapus buku

Petugas **tidak dapat meminjam buku**.

### Laporan

Petugas dapat:

* Mengakses halaman laporan
* Melakukan **generate laporan**
* Menghasilkan laporan dalam bentuk **PDF**

---

## 3. Admin

Admin memiliki akses penuh terhadap sistem.

### Alur Admin

1. Admin melakukan **login** ke dalam sistem.
2. Admin dapat mengakses beberapa halaman utama:

### Kelola Kategori

* Menambah kategori
* Mengedit kategori
* Menghapus kategori

### Kelola Buku

* Menambah buku
* Mengedit buku
* Menghapus buku

### Laporan

* Generate laporan
* Export laporan menjadi **PDF**

### Kelola User

Admin dapat:

* Menambah user
* Menambah admin
* Menambah petugas
* Menambah pengguna
* Mengubah identitas user

Catatan:

* **Admin tidak dapat mengubah identitas dirinya sendiri**

---

# Role Pengguna

| Role     | Deskripsi                              |
| -------- | -------------------------------------- |
| Pengguna | User yang meminjam dan membaca buku    |
| Petugas  | Mengelola data buku dan kategori       |
| Admin    | Mengelola seluruh sistem termasuk user |

---

# Teknologi yang Digunakan

* Laravel
* Livewire
* Tailwind CSS
* SQLite / MySQL
* PDF Generator

---

# Tujuan Aplikasi

Aplikasi ini dibuat untuk mempermudah proses:

* Pencarian buku
* Peminjaman buku
* Pengelolaan buku
* Pengelolaan kategori
* Pembuatan laporan perpustakaan
