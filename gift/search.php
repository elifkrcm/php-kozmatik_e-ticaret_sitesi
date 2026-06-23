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
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>

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
  
</head>
<body>
   
   <?php 
$aktif_sayfa = 'search';
include("header.php"); 
?>
   
<?php
if (isset($_GET['q'])) {
    $searchTerm = trim($_GET['q']);
    if (!empty($searchTerm)) {
        
		include("veritabani.php");

        // Arama sorgusu
        $stmt = $baglanti->prepare("SELECT * FROM urunler WHERE marka LIKE ? OR kategori LIKE ?");
        $searchQuery = "%" . $searchTerm . "%";
        $stmt->bind_param("ss", $searchQuery, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/shop.css">
            <title>DEAMC</title>
        </head>
        <body>
		<br>
            <h1>Arama Sonuçları</h1>
		<br>';
        if ($result->num_rows > 0) {
        // Verileri yazdır
        while ($row = $result->fetch_assoc()) {
            echo "<div class='urun'>";
            
            // Resmi detay sayfasına bağlantılı hale getirme
            echo "<a href='detay.php?urun_id=" . $row['urun_id'] . "'>";
            echo "<img src='" . $row['resim_url'] . "' alt='" . $row['urun_adi'] . "'>";
            echo "</a>";
            
            echo "<h2><b>" . $row['marka'] . "</b></h2>";
            echo "<h2>" . $row['urun_adi'] . "</h2>";
            echo "<p><strong>Fiyat:</strong> " . $row['urun_fiyat'] . " TL</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Hiç ürün bulunamadı.</p>";
    }

        echo '</body></html>';

        // Kaynakları serbest bırakma
        $stmt->close();
        $baglanti->close();
    } else {
        echo "<p>Lütfen bir arama terimi girin.</p>";
    }
}
?>



	
	
<br><br><br><br><br><br><br><br><br><br>


<?php include("info.php"); ?>
 


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
