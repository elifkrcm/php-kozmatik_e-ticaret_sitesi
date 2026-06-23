<?php
header('Content-Type: text/html; charset=UTF-8');

// Veritabanı bilgileri
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "demackrf_cosmetic";
$port = 3306;

// Veritabanına bağlan
$baglanti = new mysqli($host, $kullanici, $sifre, $veritabani, $port);

// Bağlantı kontrolü
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

// Türkçe karakter desteği
$baglanti->set_charset("utf8mb4");
?>