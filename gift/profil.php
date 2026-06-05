<?php
	session_start();
	include("veritabani.php");		
	

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

	// Kullanıcı bilgilerini çek
	$kullanici_id = $_SESSION['kullanici_id'];
	$sql = "SELECT ad_soyad, email, telefon, adres FROM kullanicilar WHERE kullanici_id = ?";
	$stmt = $baglanti->prepare($sql);
	$stmt->bind_param("i", $kullanici_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$kullanici = $result->fetch_assoc();
	} else {
		echo "Kullanıcı bilgileri bulunamadı!";
		exit;
	}
	
		$baglanti->close();

?>



<!DOCTYPE html>
<html lang="en">
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
  
</head>
<body>

<?php 
$aktif_sayfa = 'profil';
include("header.php"); 
?>

<br><br>
	<div class="container mt-5">
		<h2>Hoş Geldiniz, <?php echo htmlspecialchars($kullanici['ad_soyad']); ?>!</h2>
		<div class="card mt-4">
			<div class="card-header background-color: #CC9999; color: white;">
				<h4 class="mb-0">Kullanıcı Bilgileri</h4>
			</div>
			<div class="card-body">
				<table class="table table-striped">
					<tr>
						<th>İsim</th>
						<td><?php echo htmlspecialchars($kullanici['ad_soyad']); ?></td>
					</tr>
					<tr>
						<th>E-posta</th>
						<td><?php echo htmlspecialchars($kullanici['email']); ?></td>
					</tr>
					<tr>
						<th>Telefon</th>
						<td><?php echo htmlspecialchars($kullanici['telefon']); ?></td>
					</tr>
					<tr>
						<th>Adres</th>
						<td>
							<?php
								echo $kullanici['adres'] ? htmlspecialchars($kullanici['adres']) : "Adres girilmedi.";
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="card-footer text-center">
				<a href="cikis.php" class="btn btn-danger">Çıkış Yap</a>
				 <a href="edit_profil.php" class="btn btn-success ml-3">Düzenle</a>
			</div>
		</div>
	</div>

	<br><br><br><br><br><br><br>

<?php include("info.php"); ?>

  <script src="js/script.js"></script>
</body>
</html>
