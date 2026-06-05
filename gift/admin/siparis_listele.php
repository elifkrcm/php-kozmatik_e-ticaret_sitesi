<?php
include("baglanti.php");
include("navbar.php");

// Arama sorgusu
$ad_soyad = isset($_GET['ad_soyad']) ? $_GET['ad_soyad'] : '';

// Siparişleri çek, isime göre filtrele
$filtre_sql = "SELECT * FROM siparisler WHERE ad_soyad LIKE :ad_soyad ORDER BY siparis_id DESC";
$stmt = $baglanti->prepare($filtre_sql);

// 'ad_soyad' parametresine % ile arama yapılacak
$stmt->bindValue(':ad_soyad', '%' . $ad_soyad . '%', PDO::PARAM_STR);
$stmt->execute();

// siparis_id'ye göre grupla
$siparisler = [];
foreach ($stmt as $satir) {
    $siparis_id = $satir['siparis_id'];
    if (!isset($siparisler[$siparis_id])) {
        $siparisler[$siparis_id] = [
            'kullanici_id' => $satir['kullanici_id'],
            'ad_soyad' => $satir['ad_soyad'],
            'email' => $satir['email'],
            'telefon' => $satir['telefon'],
            'adres' => $satir['adres'],
            'odeme_yontemi' => $satir['odeme_yontemi'],
            'siparis_tarihi' => $satir['siparis_tarihi'],
            'urunler' => [],
        ];
    }
    // Ürünleri sipariş içine ekle
    $siparisler[$siparis_id]['urunler'][] = [
        'urun_adi' => $satir['urun_adi'],
        'urun_adet' => $satir['urun_adet'],
        'toplam_fiyat' => $satir['toplam_fiyat']
    ];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Siparişler</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            padding: 0;
        }

        h2 {
            color: #3f4a63;
            text-align: center;
            margin-bottom: 30px;
        }

        .siparis-karti {
            background: #fff;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .siparis-karti h3 {
            color: #3f4a63;
        }

        .urunler {
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .urun {
            margin-bottom: 8px;
        }

        .etiket {
            font-weight: bold;
            color: #333;
        }

        a.guncelle {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 12px;
            background-color: #3f4a63;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        a.guncelle:hover {
            background-color: #5a6b8d;
        }
    </style>
</head>
<body>

<h2>Siparişler</h2>

<!-- Arama Formu -->
<form method="GET" style="text-align: center; margin-bottom: 20px;">
    <input type="text" name="ad_soyad" placeholder="Ad Soyad Ara" value="<?= htmlspecialchars($ad_soyad) ?>" style="padding: 8px 15px; width: 300px; border-radius: 5px;">
    <button type="submit" style="padding: 8px 15px; background-color: #3f4a63; color: white; border: none; border-radius: 6px; cursor: pointer;">Ara</button>
    <a href="siparis_listele.php" style="padding: 8px 15px; background-color: #3f4a63; color: white; text-decoration: none; border-radius: 6px; margin-left: 10px;">Tümünü Göster</a>
</form>

<?php if (count($siparisler) === 0): ?>
    <p style="text-align: center;">Hiç sipariş bulunamadı.</p>
<?php endif; ?>

<?php foreach ($siparisler as $siparis_id => $siparis): ?>
    <div class="siparis-karti">
        <h3>Sipariş ID: <?= $siparis_id ?></h3>
        <p><span class="etiket">Ad Soyad:</span> <?= $siparis['ad_soyad'] ?></p>
        <p><span class="etiket">Email:</span> <?= $siparis['email'] ?></p>
        <p><span class="etiket">Telefon:</span> <?= $siparis['telefon'] ?></p>
        <p><span class="etiket">Adres:</span> <?= $siparis['adres'] ?></p>
        <p><span class="etiket">Ödeme Yöntemi:</span> <?= $siparis['odeme_yontemi'] ?></p>
        <p><span class="etiket">Sipariş Tarihi:</span> <?= $siparis['siparis_tarihi'] ?></p>

        <div class="urunler">
            <strong>Ürünler:</strong><br>
            <?php foreach ($siparis['urunler'] as $urun): ?>
                <div class="urun">
                    <?= $urun['urun_adi'] ?> - <?= $urun['urun_adet'] ?> adet - <?= number_format($urun['toplam_fiyat'], 2) ?> ₺
                </div>
            <?php endforeach; ?>
        </div>

        <a class="guncelle" href="siparis_detay.php?siparis_id=<?= $siparis_id ?>">Durumu Güncelle</a>
    </div>
<?php endforeach; ?>

</body>
</html>
