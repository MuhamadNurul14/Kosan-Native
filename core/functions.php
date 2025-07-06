<?php
// File: core/functions.php

function url($path = '') {
    $base_path = dirname($_SERVER['SCRIPT_NAME']);
    $base_url = sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], $base_path);
    return rtrim($base_url, '/') . '/' . ltrim($path, '/');
}

function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// -- FUNGSI-FUNGSI BARU UNTUK DATABASE 'ngekos' --

// Mengambil semua data dari sebuah tabel
function get_all_data($pdo, $tableName) {
    $stmt = $pdo->query("SELECT * FROM {$tableName}");
    return $stmt->fetchAll();
}

// Mengambil semua data kos dengan join ke kategori dan kota
function get_all_kos($pdo) {
    $sql = "SELECT bh.*, c.name as city_name, cat.name as category_name 
            FROM boarding_houses bh
            JOIN cities c ON bh.city_id = c.id
            JOIN categories cat ON bh.category_id = cat.id
            ORDER BY bh.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Mengambil detail satu kos berdasarkan ID, termasuk data terkait
function get_kos_details($pdo, $id) {
    $details = [];
    
    // Ambil data utama kos
    $stmt = $pdo->prepare("SELECT bh.*, c.name as city_name, cat.name as category_name FROM boarding_houses bh JOIN cities c ON bh.city_id = c.id JOIN categories cat ON bh.category_id = cat.id WHERE bh.id = ?");
    $stmt->execute([$id]);
    $details['kos'] = $stmt->fetch();

    if (!$details['kos']) return null;

    // Ambil data kamar (rooms)
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE boarding_house_id = ? AND is_available = 1");
    $stmt->execute([$id]);
    $details['rooms'] = $stmt->fetchAll();

    // Ambil data bonus
    $stmt = $pdo->prepare("SELECT * FROM bonuses WHERE boarding_house_id = ?");
    $stmt->execute([$id]);
    $details['bonuses'] = $stmt->fetchAll();

    // Ambil data testimoni
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE boarding_house_id = ?");
    $stmt->execute([$id]);
    $details['testimonials'] = $stmt->fetchAll();

    return $details;
}

// Fungsi pencarian yang diperbarui
function search_kos($pdo, $name, $city_id, $category_id) {
    $sql = "SELECT bh.*, c.name as city_name, cat.name as category_name 
            FROM boarding_houses bh
            JOIN cities c ON bh.city_id = c.id
            JOIN categories cat ON bh.category_id = cat.id
            WHERE 1=1";
    $params = [];

    if (!empty($name)) {
        $sql .= " AND bh.name LIKE ?";
        $params[] = "%" . $name . "%";
    }
    if (!empty($city_id)) {
        $sql .= " AND bh.city_id = ?";
        $params[] = $city_id;
    }
    if (!empty($category_id)) {
        $sql .= " AND bh.category_id = ?";
        $params[] = $category_id;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

