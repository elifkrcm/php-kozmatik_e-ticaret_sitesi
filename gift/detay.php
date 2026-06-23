<?php
session_start(); // Oturumu başlat
include("veritabani.php");

// --- ÜRÜN DETAYINI ÇEK ---
$id = isset($_GET['urun_id']) ? (int)$_GET['urun_id'] : 0;
$stmt = $baglanti->prepare("SELECT * FROM urunler WHERE urun_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$sonuc = $stmt->get_result();
$urun = $sonuc->fetch_assoc();

if (!$urun) {
    die("Ürün bulunamadı.");
}

// --- ORTALAMA PUAN ---
$stmt = $baglanti->prepare("SELECT AVG(puan) AS average_rating FROM yorumlar WHERE urun_id = ?");
$stmt->bind_param("i", $urun['urun_id']);
$stmt->execute();
$result = $stmt->get_result();
$puanlar = $result->fetch_assoc();
$ortalama_puan = $puanlar['average_rating'] ? round($puanlar['average_rating'], 1) : 0;

// --- SEPETE EKLEME ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $kullanici_id = isset($_SESSION['kullanici_id']) ? $_SESSION['kullanici_id'] : 1;
    $urun_id = $_POST['product_id'];
    $urun_adi = $_POST['product_name'];
    $urun_fiyat = $_POST['product_price'];

    $stmt = $baglanti->prepare("SELECT * FROM sepet WHERE kullanici_id = ? AND urun_id = ?");
    $stmt->bind_param("ii", $kullanici_id, $urun_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingProduct = $result->fetch_assoc();

    if ($existingProduct) {
        $updateStmt = $baglanti->prepare("UPDATE sepet SET miktar = miktar + 1 WHERE urun_id = ?");
        $updateStmt->bind_param("i", $existingProduct['urun_id']);
        $updateStmt->execute();
    } else {
        $insertStmt = $baglanti->prepare("INSERT INTO sepet (kullanici_id, urun_id, urun_adi, urun_fiyat, miktar) VALUES (?, ?, ?, ?, 1)");
        $insertStmt->bind_param("iisd", $kullanici_id, $urun_id, $urun_adi, $urun_fiyat);
        $insertStmt->execute();
    }

    $message = "Ürün sepete eklendi!";
}

// --- YORUMLARI ÇEKME ---
$stmt = $baglanti->prepare("SELECT * FROM yorumlar WHERE urun_id = ? ORDER BY tarih DESC");
$stmt->bind_param("i", $urun['urun_id']);
$stmt->execute();
$result = $stmt->get_result();
$yorumlar = $result->fetch_all(MYSQLI_ASSOC);

// --- YORUM EKLEME ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yorum'], $_POST['puan'])) {
    if (!isset($_SESSION['kullanici_id'])) {
        $message = "Yorum yapabilmek için giriş yapmalısınız.";
    } else {
        $kullanici_id = $_SESSION['kullanici_id'];
        $yorum = $_POST['yorum'];
        $puan = (int)$_POST['puan'];
        $urun_id = $urun['urun_id'];

        $insertYorumStmt = $baglanti->prepare("INSERT INTO yorumlar (urun_id, kullanici_id, yorum, puan) VALUES (?, ?, ?, ?)");
        if ($insertYorumStmt) {
            $insertYorumStmt->bind_param("iisi", $urun_id, $kullanici_id, $yorum, $puan);
            $insertYorumStmt->execute();
            $message = "Yorumunuz başarıyla eklendi!";
        } else {
            $message = "Yorum eklenirken bir hata oluştu.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
     <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>
    DEMAC
  </title>
  
  <script>
        // Sekme değiştiğinde başlık değiştirme
        let originalTitle = document.title; // Başlangıçtaki başlık

        // Kullanıcı sekme değiştirdiğinde
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Sekme gizlendiğinde (yani başka bir sekme açıldığında)
                document.title = "Bizi Unutma <3";
            } else {
                // Sekme geri aktif olduğunda
                document.title = originalTitle; // Başlangıç başlığına geri dön
            }
        });
    </script>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link href="css/shop.css" rel="stylesheet" />
  <link href="css/detay.css" rel="stylesheet" />
 

<style>
    .yorumlar-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
		background-color:WhiteSmoke ;
		border-radius:15px;
    }

    h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }

    .yorum {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        text-align: left;
    }

    .yorum strong {
        font-size: 16px;
        color: #333;
    }

    .yorum p {
        font-size: 14px;
        color: #555;
        margin: 10px 0;
    }

    .puan i {
        color: #f39c12;
    }

    .tarih {
        font-size: 12px;
        color: #999;
        margin-top: 10px;
    }

    .yorum-form {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        width: 100%;
        max-width: 600px;
        margin: 20px 0;
        text-align: left;
		margin:auto;
    }

    .yorum-form textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        resize: none;
    }

    .yorum-form select, .yorum-form button {
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .yorum-form button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    .yorum-form button:hover {
        background-color: #45a049;
    }

    .yorum-form label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }

    p {
        font-size: 14px;
    }
</style>
</head>
<body>
<?php 
$aktif_sayfa = 'shop';
include("header.php"); 
?>

  <br>
     <h1>Ürün Detayları</h1>

<div class="product-detail">
    <img src="<?= htmlspecialchars($urun['resim_url']); ?>" alt="<?= htmlspecialchars($urun['urun_adi']); ?>" class="product-image">
    <div class="product-info">
        <h2><?= htmlspecialchars($urun['urun_adi']); ?></h2>
        <p class="description"><?= htmlspecialchars($urun['aciklama']); ?></p>
        <p><strong>Fiyat:</strong> <?= number_format($urun['urun_fiyat'], 2); ?> ₺</p>

        <!-- Ortalama Puanı Göster -->
        <div class="average-rating">
            <p><strong>Ortalama Puan:</strong> <?= $ortalama_puan; ?> Yıldız</p>
            <div class="stars">
                <?php for ($i = 0; $i < floor($ortalama_puan); $i++): ?>
                    <i class="fa fa-star"></i>
                <?php endfor; ?>
                <?php if ($ortalama_puan - floor($ortalama_puan) >= 0.5): ?>
                    <i class="fa fa-star-half-o"></i>
                <?php endif; ?>
            </div>
        </div>
        <br>
        <form method="post" action="">
            <input type="hidden" name="product_id" value="<?= $urun['urun_id']; ?>">
            <input type="hidden" name="product_name" value="<?= htmlspecialchars($urun['urun_adi']); ?>">
            <input type="hidden" name="product_price" value="<?= $urun['urun_fiyat']; ?>">
            <button type="submit" style="background-color: #E4256C;">Sepete Ekle</button>
        </form>
    </div>
</div>
<!-- Yorumlar Container -->
<div class="yorumlar-container">
    <h2>Yorumlar</h2>
    <?php if (!empty($yorumlar)): ?>
        <?php foreach ($yorumlar as $yorum): ?>
            <?php
            // Kullanıcı adı ve soyadını almak
            $stmt = $baglanti->prepare("SELECT ad_soyad FROM kullanicilar WHERE kullanici_id = ?");
            $stmt->bind_param("i", $yorum['kullanici_id']);
            $stmt->execute();
            $sonuc = $stmt->get_result();
            $kullanici = $sonuc->fetch_assoc();
            $adSoyad = explode(" ", $kullanici['ad_soyad']);
            $ad = $adSoyad[0];
            $soyad = isset($adSoyad[1]) ? $adSoyad[1] : '';
            $soyadGizli = substr($soyad, 0, 1) . '**';
            ?>
            <div class="yorum">
                <strong><?= htmlspecialchars($ad); ?> <?= htmlspecialchars($soyadGizli); ?></strong>
                <p><?= htmlspecialchars($yorum['yorum']); ?></p>
                <div class="puan">
                    <?php for ($i = 0; $i < $yorum['puan']; $i++): ?>
                        <i class="fa fa-star"></i>
                    <?php endfor; ?>
                </div>
                <span class="tarih"><?= htmlspecialchars($yorum['tarih']); ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Henüz yorum yapılmamış.</p>
    <?php endif; ?>

    <!-- Yorum ekleme formu -->
    <?php if (isset($_SESSION['kullanici_id'])): ?>
        <form method="post" action="" class="yorum-form">
            <textarea name="yorum" required placeholder="Yorumunuzu yazın..."></textarea>
            <label for="puan">Puan:</label>
            <select name="puan" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <button type="submit" style="background-color: #E4256C;">Yorum Yap</button>
        </form>
    <?php else: ?>
        <p><strong>Yorum yapabilmek için giriş yapmalısınız.</strong></p>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
</div>



</body>
</html>
