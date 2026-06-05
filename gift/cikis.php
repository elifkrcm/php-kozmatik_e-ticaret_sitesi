<?php
session_start();
session_unset(); // Tüm oturum verilerini temizler
session_destroy(); // Oturumu sonlandırır
header("Location:giris.php"); // Giriş sayfasına yönlendir
exit;
?>
