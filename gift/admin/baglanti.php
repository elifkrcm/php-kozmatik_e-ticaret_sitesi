<?php
header('Content-Type: text/html; charset=UTF-8');

try {
    $baglanti = new PDO(
        "mysql:host=localhost;dbname=demackrf_cosmetic;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>