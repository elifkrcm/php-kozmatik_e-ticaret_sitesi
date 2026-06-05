<?php
include('baglanti.php');

// Eğer POST isteği gelirse, yorumun durumu güncellenecek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $yorum_id = $_POST['yorum_id']; // Yorum ID'si
    $durum = $_POST['durum']; // Durum (Onaysız veya Onaylı)

    // Durumu güncelleme sorgusu
    $query = "UPDATE yorumlar SET durum = :durum WHERE yorum_id = :yorum_id";
    $stmt = $baglanti->prepare($query);
    $stmt->bindParam(':durum', $durum);
    $stmt->bindParam(':yorum_id', $yorum_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        header("Location: yorumlar.php"); // Yorumlar sayfasına yönlendir
        exit();
    } else {
        echo "Bir hata oluştu.";
    }
}
?>
