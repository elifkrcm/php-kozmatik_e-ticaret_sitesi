<?php
include("baglanti.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sil = $baglanti->prepare("DELETE FROM urunler WHERE urun_id = ?");
    $sil->execute([$id]);

     // Yönlendirme
    header("Location: urunler.php");
    exit;
} else {
    echo "ID bulunamadı.";
}
