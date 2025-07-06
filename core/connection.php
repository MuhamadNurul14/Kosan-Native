<?php
// File: core/connection.php

$host = 'localhost';
$dbname = 'ngekos';      // Nama database baru Anda
$user = 'root';          // User default XAMPP
$pass = '';              // Password default XAMPP kosong

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Setting agar PDO mengembalikan error sebagai exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Setting agar hasil fetch berupa associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan aplikasi dan tampilkan pesan
    die("Koneksi ke database gagal: " . $e->getMessage());
}