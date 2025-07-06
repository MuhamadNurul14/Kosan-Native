<?php
// File: index.php (Versi Perbaikan)

// Selalu mulai sesi di paling atas
session_start();

// 1. BUAT KONEKSI DATABASE TERLEBIH DAHULU
// Ini akan menciptakan variabel $pdo yang akan kita gunakan di mana-mana
require 'core/connection.php';
require 'core/functions.php';

// 2. LOGIKA ROUTING
$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$url_parts = explode('/', $url);

$page = $url_parts[0];
$id = $url_parts[1] ?? null;

$view_path = "views/{$page}.php";
$allowed_pages = [
    'home', 'details', 'categories', 'cities', 'search-result', 'find-kos',
    'room-available', 'cust-info', 'checkout', 'success-booking',
    'check-booking', 'booking-details'
];

// 3. TAMPILKAN HALAMAN
// Muat header
require 'views/partials/header.php';

// Periksa apakah halaman yang diminta ada dan diizinkan
if (in_array($page, $allowed_pages) && file_exists($view_path)) {
    // Jika ada, muat file view-nya. Variabel $pdo akan otomatis tersedia di sini.
    require $view_path;
} else {
    // Jika tidak, tampilkan halaman 404
    echo "<div class='text-center p-20'><h1>404 - Halaman Tidak Ditemukan</h1><p>Halaman yang Anda cari tidak ada.</p><a href='".url()."' class='text-blue-500 mt-4 inline-block'>Kembali ke Beranda</a></div>";
}

// Hanya tampilkan navbar di halaman tertentu
$pages_with_navbar = ['home', 'check-booking', 'find-kos'];
if (in_array($page, $pages_with_navbar)) {
    require 'views/partials/navbar.php';
}

// Muat scripts
require 'views/partials/scripts.php';