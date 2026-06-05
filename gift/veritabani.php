<?php
header('Content-Type: text/html; charset=UTF-8');
$host = "localhost"; // Sunucu
$kullanici = "demackrf_demackrf"; // phpMyAdmin kullanıcı adı
$sifre = "Quosp069"; // phpMyAdmin şifresi (varsayılan: boş)
$veritabani = "demackrf_cosmetic"; // Veritabanı adı
$port = 3306;


// Veritabanı bağlantısını oluştur
$baglanti = new mysqli($host, $kullanici, $sifre, $veritabani,$port);
$baglanti->set_charset("utf8mb4");
// Bağlantıyı kontrol et
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

?>
