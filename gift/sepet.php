<?php
session_start();


// Oturumda kullanıcı ID'sinin olup olmadığını kontrol et
if (!isset($_SESSION['kullanici_id'])) {
    echo '
    <html>
    <head>
        <style>
            body {
                margin: 0;
                background-color: #f2f2f2;
                font-family: Arial, sans-serif;
            }
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
            .notification.show {
                top: 0;
            }
        </style>
        <script>
            window.onload = function() {
                const notification = document.querySelector(".notification");
                notification.classList.add("show");
            };
        </script>
    </head>
    <body>
        <div class="notification">Lütfen giriş yapın. Giriş ekranına yönlendiriliyorsunuz.</div>
        <script>
            setTimeout(function() {
                window.location.href = "giris.php";
            }, 2000); // 2 saniye sonra yönlendir
        </script>
    </body>
    </html>
    ';
    exit;
}

$kullanici_id = $_SESSION['kullanici_id']; // Giriş yapan kullanıcının ID'si



    include("veritabani.php");

    // Sepetteki ürünleri çek
$stmt = $baglanti->prepare("SELECT * FROM sepet WHERE kullanici_id = ?");
$stmt->bind_param("i", $kullanici_id); // "i" integer anlamına gelir
$stmt->execute();
$sonuc = $stmt->get_result();

$sepet = [];
while ($row = $sonuc->fetch_assoc()) {
    $sepet[] = $row;
}


    
// Ürün miktarını azaltma veya tamamen silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['urun_sil'])) {
    $urun_id = $_POST['urun_sil'];

    // Mevcut miktarı kontrol et
    $stmt = $baglanti->prepare("SELECT miktar FROM sepet WHERE sepet_id = ? AND kullanici_id = ?");
    $stmt->bind_param("ii", $urun_id, $kullanici_id);
    $stmt->execute();
    $sonuc = $stmt->get_result();
    $urun = $sonuc->fetch_assoc();

    if ($urun) {
        if ($urun['miktar'] > 1) {
            // Miktarı 1 azalt
            $stmt = $baglanti->prepare("UPDATE sepet SET miktar = miktar - 1 WHERE sepet_id = ? AND kullanici_id = ?");
            $stmt->bind_param("ii", $urun_id, $kullanici_id);
            $stmt->execute();
        } else {
            // Miktar 1 ise tamamen sil
            $stmt = $baglanti->prepare("DELETE FROM sepet WHERE sepet_id = ? AND kullanici_id = ?");
            $stmt->bind_param("ii", $urun_id, $kullanici_id);
            $stmt->execute();
        }
    }

    // Sepet sayfasına yönlendir
    header("Location: sepet.php");
    exit;
}



// Sepeti boşaltma işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sepeti_bosalt'])) {
    // Veritabanından tüm ürünleri sil
    $stmt = $baglanti->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
    $stmt->bind_param("i", $kullanici_id);
    $stmt->execute();

    header("Location: sepet.php");
    exit;
}

// Toplam fiyat hesaplama
$toplamFiyat = 0;
foreach ($sepet as $item) {
    $toplamFiyat += $item['urun_fiyat'] * $item['miktar'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    
    <title>DEMAC</title>

    <script>
        let originalTitle = document.title; // Başlangıçtaki başlık

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                document.title = "Bizi Unutma <3";
            } else {
                document.title = originalTitle; // Başlangıç başlığına geri dön
            }
        });
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <link href="css/sepet.css" rel="stylesheet" />
</head>
<body>

<?php 
$aktif_sayfa = 'sepet';
include("header.php"); 
?>

<br><br>

<h1>Sepet</h1>

<?php if (empty($sepet)): ?>
    <p style="margin-left: 200px;">Sepetiniz boş!</p>
<?php else: ?>
    <form action="sepet.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Fiyat</th>
                    <th>Miktar</th>
                    <th>Toplam</th>
                    <th>Sil</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sepet as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['urun_adi']); ?></td>
                        <td><?= number_format($item['urun_fiyat'], 2); ?> ₺</td>
                        <td><?= $item['miktar']; ?></td>
                        <td><?= number_format($item['urun_fiyat'] * $item['miktar'], 2); ?> ₺</td>
                        <td>
                            <form method="post" action="">
                                <button type="submit" name="urun_sil" value="<?= $item['sepet_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" name="sepeti_bosalt" class="bosalt-btn"><i class="fa fa-trash" aria-hidden="true"></i> Sepeti Boşalt</button>
    </form>

    <p style="margin-left: 200px;"><strong>Toplam:</strong> <?= number_format($toplamFiyat, 2); ?> ₺</p>
    <a href="odeme.php" class="onayla-btn" style="background-color: #E4256C;">Siparişi Onayla</a>
<?php endif; ?>

<script src="js/script.js"></script>
</body>
</html>
