<?php
include("baglanti.php");
include("navbar.php");
if (isset($_GET['siparis_id'])) {
    $siparis_id = $_GET['siparis_id'];

    // Sipariş bilgilerini al
    $siparis_sorgu = $baglanti->prepare("SELECT * FROM siparisler WHERE siparis_id = ?");
    $siparis_sorgu->execute([$siparis_id]);
    $siparis = $siparis_sorgu->fetch();

    // Sipariş durumu güncelleme işlemi
    if (isset($_POST['durum'])) {
        $yeni_durum = $_POST['durum'];
        $update_siparis = $baglanti->prepare("UPDATE siparisler SET durum = ? WHERE siparis_id = ?");
        $update_siparis->execute([$yeni_durum, $siparis_id]);
        header("Location: siparis_listele.php");  // Listeleme sayfasına yönlendir
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Detayı</title>
    <style>
        /* Genel Sayfa Stili */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Başlık */
        h2 {
            text-align: center;
            color: #3f4a63;
			margin:70px auto;
        }

        /* Bilgileri yatay olarak düzenleme */
        .siparis-bilgiler {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .siparis-bilgiler div {
            font-size: 16px;
            color: #555;
        }

        .siparis-bilgiler strong {
            color: #3f4a63;
        }

        /* Durum Güncelleme Formu */
        select, button {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
			 width: 200px; /* Yeni genişlik */
        }

        select {
           
            margin-top: 5px;
        }

        button {
            background-color: #3f4a63;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
			margin-left:55px;
           
        }

        button:hover {
            background-color: #5a6b8d;
        }
    </style>
</head>
<body>

<h2>Sipariş Detayı</h2>

<div class="siparis-bilgiler">
    <div><strong>Sipariş ID:<br></strong> <?= $siparis['siparis_id'] ?></div>
    <div><strong>Kullanıcı Adı:<br></strong> <?= $siparis['ad_soyad'] ?></div>
    <div><strong>Ürün Adı:<br></strong> <?= $siparis['urun_adi'] ?></div>
    <div><strong>Ürün Adedi:<br></strong> <?= $siparis['urun_adet'] ?></div>
    <div><strong>Toplam Fiyat:<br></strong> <?= $siparis['toplam_fiyat'] ?> ₺</div>
    <div><strong>Sipariş Tarihi:<br></strong> <?= $siparis['siparis_tarihi'] ?></div>
    <div><strong>Ödeme Yöntemi:<br></strong> <?= $siparis['odeme_yontemi'] ?></div>
</div>

<form method="POST">
    <label for="durum">Durum:</label>
    <select name="durum" id="durum">
        <option value="Yeni" <?= $siparis['durum'] == 'Yeni' ? 'selected' : '' ?>>Yeni</option>
        <option value="Kargoya Verildi" <?= $siparis['durum'] == 'Kargoya Verildi' ? 'selected' : '' ?>>Kargoya Verildi</option>
        <option value="Teslim Edildi" <?= $siparis['durum'] == 'Teslim Edildi' ? 'selected' : '' ?>>Teslim Edildi</option>
    </select>
    <br><br>
    <button type="submit">Durumu Güncelle</button>
</form>

</body>
</html>
