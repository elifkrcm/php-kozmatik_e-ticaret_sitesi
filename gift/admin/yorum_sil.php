<?php
include('baglanti.php');

// Yorum ID'si URL parametresinden alınacak
if (isset($_GET['yorum_id'])) {
    $yorum_id = $_GET['yorum_id'];

    // Yorum silme sorgusu
    $query = "DELETE FROM yorumlar WHERE yorum_id = :yorum_id";
    $stmt = $baglanti->prepare($query);
    $stmt->bindParam(':yorum_id', $yorum_id, PDO::PARAM_INT);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        header("Location: yorumlar.php"); // Yorumlar sayfasına yönlendir
        exit();
    } else {
        echo "Bir hata oluştu.";
    }
} else {
    echo "Yorum ID'si eksik.";
}
?>
