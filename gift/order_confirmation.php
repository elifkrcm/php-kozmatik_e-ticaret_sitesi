<?php
session_start();

if (!isset($_SESSION['kullanici_id'])) {
    echo "Giriş yapmanız gerekiyor.";
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_soyad = htmlspecialchars($_POST['ad_soyad']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telefon = htmlspecialchars($_POST['telefon']);
    $adres = htmlspecialchars($_POST['adres']);
    $odeme = htmlspecialchars($_POST['odeme']);

    if (!$email) {
        echo "Geçersiz e-posta adresi.";
        exit;
    }

    try {
        include("veritabani.php");

        // Sepeti çek
        $stmt = $baglanti->prepare("SELECT * FROM sepet WHERE kullanici_id = ?");
        $stmt->bind_param("i", $kullanici_id);
        $stmt->execute();
        $sonuc = $stmt->get_result();
        $sepet = [];

        while ($row = $sonuc->fetch_assoc()) {
            $sepet[] = $row;
        }

        if (empty($sepet)) {
            echo "Sepetiniz boş!";
            exit;
        }

        // Yeni sipariş ID oluştur
        $result = $baglanti->query("SELECT MAX(siparis_id) AS max_id FROM siparisler");
        $row = $result->fetch_assoc();
        $yeni_siparis_id = $row['max_id'] + 1;
        if (!$yeni_siparis_id) $yeni_siparis_id = 1;

        // Stok kontrolü ve düşürme
        foreach ($sepet as $item) {
            $urun_adi = $item['urun_adi'];
            $urun_adet = $item['miktar'];

            // Ürün stok_adedi kontrolü
            $stok_sorgu = $baglanti->prepare("SELECT stok_adedi FROM urunler WHERE urun_adi = ?");
            $stok_sorgu->bind_param("s", $urun_adi);
            $stok_sorgu->execute();
            $stok_sonuc = $stok_sorgu->get_result();
            $urun = $stok_sonuc->fetch_assoc();

            if (!$urun || $urun['stok_adedi'] < $urun_adet) {
                echo $urun_adi . " ürünü için yeterli stok bulunmamaktadır.";
                exit;
            }

            // Stoktan düş
            $yeni_stok = $urun['stok_adedi'] - $urun_adet;
            $stok_guncelle = $baglanti->prepare("UPDATE urunler SET stok_adedi = ? WHERE urun_adi = ?");
            $stok_guncelle->bind_param("is", $yeni_stok, $urun_adi);
            $stok_guncelle->execute();
        }

        // Siparişi kaydet
        foreach ($sepet as $item) {
            $stmt = $baglanti->prepare("INSERT INTO siparisler 
                (siparis_id, kullanici_id, urun_adi, urun_adet, toplam_fiyat, siparis_tarihi, ad_soyad, email, telefon, adres, odeme_yontemi) 
                VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)");

            $urun_adi = $item['urun_adi'];
            $urun_adet = $item['miktar'];
            $toplam_fiyat = $item['urun_fiyat'] * $urun_adet;

            $stmt->bind_param(
                "iisidsssss",
                $yeni_siparis_id,
                $kullanici_id,
                $urun_adi,
                $urun_adet,
                $toplam_fiyat,
                $ad_soyad,
                $email,
                $telefon,
                $adres,
                $odeme
            );

            $stmt->execute();
        }

        // Sepeti temizle
        $stmt = $baglanti->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
        $stmt->bind_param("i", $kullanici_id);
        $stmt->execute();

        header("Location: siparislerim.php");
        exit;

    } catch (Exception $e) {
        echo "Sipariş işlemi sırasında bir hata oluştu: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek.";
}
?>
