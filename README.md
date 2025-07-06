# **Aplikasi Pencarian Kos "Ngekos" (Versi PHP Native)**

Ini adalah aplikasi web sederhana yang dibangun menggunakan PHP native untuk mencari dan melihat informasi mengenai kos-kosan (boarding house). Proyek ini merupakan hasil konversi dari template HTML statis menjadi aplikasi web dinamis yang terhubung dengan database MySQL.

Aplikasi ini dirancang untuk mensimulasikan alur kerja dasar dari sebuah platform pencarian properti, mulai dari melihat daftar, memfilter, hingga proses pemesanan awal.

## **Fitur Utama ✨**

  * **Tampilan Beranda Dinamis:** Menampilkan daftar kategori, kota, dan kos-kosan populer yang datanya diambil langsung dari database.
  * **Pencarian & Filter:** Pengguna dapat mencari kos berdasarkan nama, kota, dan kategori melalui form pencarian.
  * **Halaman Detail:** Setiap kos memiliki halaman detailnya sendiri yang menampilkan informasi lengkap seperti deskripsi, fasilitas (bonus), kamar yang tersedia, dan testimoni.
  * **Alur Pemesanan (Booking Flow):**
      * Memilih kamar yang tersedia dari halaman detail.
      * Mengisi informasi data diri pelanggan.
      * Melihat rincian checkout dan total biaya.
      * Menyimpan data transaksi ke dalam database.
      * Menampilkan halaman konfirmasi booking berhasil.
  * **Cek Status Booking:** Pengguna dapat memeriksa detail transaksi mereka dengan memasukkan kode booking dan email.
  * **URL Bersih (Clean URLs):** Menggunakan `.htaccess` untuk membuat URL lebih rapi dan ramah SEO (misalnya, `/details/1` bukan `/index.php?page=details&id=1`).
  * **Struktur MVC Sederhana:** Mengadopsi pola yang terinspirasi dari Model-View-Controller (MVC) untuk memisahkan logika, data, dan tampilan.

## **Tumpukan Teknologi (Technology Stack) 💻**

  * **Backend:** PHP Native (tanpa framework)
  * **Database:** MySQL
  * **Frontend:** HTML, Tailwind CSS
  * **JavaScript:** Vanilla JS, [Swiper.js](https://swiperjs.com/) (untuk slider/carousel)
  * **Server Lokal:** XAMPP (Apache, MySQL, PHP)

## **Panduan Instalasi & Setup 🚀**

Untuk menjalankan proyek ini di komputer lokal Anda, ikuti langkah-langkah berikut:

#### **1. Prasyarat**

  * Pastikan Anda sudah menginstal **XAMPP** atau server lokal sejenis yang sudah mencakup Apache, MySQL, dan PHP.

#### **2. Setup Database**

  * Jalankan modul **Apache** dan **MySQL** dari XAMPP Control Panel.
  * Buka **phpMyAdmin** (biasanya melalui `http://localhost/phpmyadmin`).
  * Buat database baru dengan nama `ngekos`.
  * Pilih database `ngekos` yang baru dibuat, lalu klik tab **"Import"**.
  * Pilih file `ngekos.sql` yang sudah Anda miliki, lalu klik **"Go"** untuk mengimpor struktur tabel dan data awal.

#### **3. Setup Proyek**

  * Salin seluruh folder proyek ini (`Ngekos-PHP/`) ke dalam direktori `htdocs` di dalam folder instalasi XAMPP Anda.
      * Contoh path di Windows: `C:/xampp/htdocs/Ngekos-PHP/`
  * Pastikan semua file, termasuk `.htaccess`, sudah tersalin dengan benar.

#### **4. Jalankan Aplikasi**

  * Buka browser Anda (Chrome, Firefox, dll.).
  * Ketik alamat berikut di address bar:
    ```
    http://localhost/Ngekos-PHP/
    ```
  * Aplikasi sekarang seharusnya sudah berjalan dengan baik.

## **Struktur Proyek 📁**

  * **`/assets`**: Berisi semua file statis seperti CSS, JavaScript, dan gambar.
  * **`/core`**: Berisi logika inti aplikasi.
      * `connection.php`: Menangani koneksi ke database MySQL menggunakan PDO.
      * `functions.php`: Kumpulan fungsi PHP yang dapat digunakan kembali.
  * **`/views`**: Berisi semua file tampilan yang akan dilihat oleh pengguna.
      * `/partials`: Potongan-potongan tampilan yang digunakan berulang kali (header, navbar, scripts).
  * **`index.php`**: Pintu masuk utama (router) yang menangani semua permintaan dan memuat tampilan yang sesuai.
  * **`.htaccess`**: Mengatur URL agar lebih bersih.
  * **`ngekos.sql`**: File dump SQL untuk membuat dan mengisi database.
