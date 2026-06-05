<?php
session_start();

try {
    include("veritabani.php");

    if (!isset($_SESSION['kullanici_id'])) {
        echo '
        <html>
        <head>
            <style>
                body { margin: 0; background-color: #f2f2f2; font-family: Arial, sans-serif; }
                .notification {
                    position: fixed;
                    top: -50px;
                    left: 0;
                    width: 100%;
                    background-color: #ff4d4d;
                    color: white;
                    text-align: center;
                    padding: 15px 0;
                    font-size: 18px;
                    font-weight: bold;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                    transition: top 0.5s ease-in-out;
                    z-index: 1000;
                }
                .notification.show { top: 0; }
            </style>
            <script>
                window.onload = function() {
                    document.querySelector(".notification").classList.add("show");
                };
            </script>
        </head>
        <body>
            <div class="notification">Lütfen giriş yapın. Giriş ekranına yönlendiriliyorsunuz.</div>
            <script> setTimeout(() => window.location.href = "giris.php", 2000); </script>
        </body>
        </html>';
        exit;
    }

    $kullanici_id = $_SESSION['kullanici_id'];

    $stmt = $baglanti->prepare("SELECT * FROM siparisler WHERE kullanici_id = ? ORDER BY siparis_tarihi ASC");
    $stmt->bind_param("i", $kullanici_id);
    $stmt->execute();
    $sonuc = $stmt->get_result();

    $siparisler = [];
    while ($row = $sonuc->fetch_assoc()) {
        $siparisler[] = $row;
    }

    // Siparişleri sipariş_id'ye göre gruplama
    $gruplar = [];
    foreach ($siparisler as $siparis) {
        $gruplar[$siparis['siparis_id']][] = $siparis;
    }

    // Sipariş No'ları sırayla oluştur
    $siparis_no_listesi = [];
    $no = 1;
    foreach (array_keys($gruplar) as $siparis_id) {
        $siparis_no_listesi[$siparis_id] = $no++;
    }

    // En yeni sipariş en üstte görünsün
    uasort($gruplar, function($a, $b) {
        return strtotime(end($b)['siparis_tarihi']) <=> strtotime(end($a)['siparis_tarihi']);
    });

} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>DEMAC</title>
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <script>
    let originalTitle = document.title;
    document.addEventListener('visibilitychange', function() {
      document.title = document.hidden ? "Bizi Unutma <3" : originalTitle;
    });
  </script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link href="css/sepet.css" rel="stylesheet" />
  <style>
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
		border-radius:15px;
    }
    .order-table th, .order-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
		
    }
    .order-table th {
        background-color: #F5699B;
        color: white;
    }
    .empty {
        font-size: 18px;
        text-align: center;
        color: #888;
        padding: 40px;
    }
    .siparis-durum.hazırlanıyor { color: orange; font-weight: bold; }
    .siparis-durum.kargoda { color: blue; font-weight: bold; }
    .siparis-durum.teslim { color: green; font-weight: bold; }
    .siparis-durum.iptal { color: red; font-weight: bold; }
  </style>
</head>
<body>

<?php 
$aktif_sayfa = 'siparis';
include("header.php"); 
?>

<br><br>

<div class="container">
    <h1>Siparişlerim</h1>

    <?php if (empty($siparisler)): ?>
        <p class="empty">Henüz sipariş vermediniz!</p>
    <?php else: ?>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Sipariş Tarihi</th>
                    <th>Ürün Adı</th>
                    <th>Adet</th>
                    <th>Toplam Fiyat</th>
                    <th>Adres</th>
                    <th>Ödeme Yöntemi</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gruplar as $siparis_id => $grup): ?>
                    <?php foreach ($grup as $index => $siparis): ?>
                        <tr>
                            <?php if ($index === 0): ?>
                                <td rowspan="<?= count($grup); ?>" style="font-weight: bold; vertical-align: middle;"><?= $siparis_no_listesi[$siparis_id]; ?></td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($siparis['siparis_tarihi']); ?></td>
                            <td><?= htmlspecialchars($siparis['urun_adi']); ?></td>
                            <td><?= $siparis['urun_adet']; ?></td>
                            <td><?= number_format($siparis['toplam_fiyat'], 2); ?> ₺</td>
                            <td><?= htmlspecialchars($siparis['adres']); ?></td>
                            <td><?= htmlspecialchars($siparis['odeme_yontemi']); ?></td>
                            <td class="siparis-durum <?= strtolower(str_replace(' ', '', $siparis['durum'])); ?>">
                                <?= htmlspecialchars($siparis['durum']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<?php include("info.php"); ?>
<script src="js/script.js"></script>
</body>
</html>
