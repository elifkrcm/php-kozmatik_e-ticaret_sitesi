<?php

include("baglanti.php");

$email = "admin@cosmetic.com";
$sifre = "777";

// Şifreyi güvenli bir şekilde hashle
$hashliSifre = password_hash($sifre, PASSWORD_DEFAULT);

// Veritabanına ekle
$sorgu = $baglanti->prepare("INSERT INTO admin (email, sifre) VALUES (?, ?)");
$sorgu->execute([$email, $hashliSifre]);

echo "Admin başarıyla eklendi.";

?>