<?php
session_start();
include("veritabani.php");

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verileri al
    $ad_soyad = $_POST['ad_soyad'];
    $email = $_POST['email'];
    $telefon = isset($_POST['telefon']) ? $_POST['telefon'] : ''; // Artık zorunlu değil
    $adres = isset($_POST['adres']) && $_POST['adres'] !== null ? $_POST['adres'] : '';

    $sql = "UPDATE kullanicilar SET ad_soyad = ?, email = ?, telefon = ?, adres = ? WHERE kullanici_id = ?";
    $stmt = $baglanti->prepare($sql);

    if (!$stmt) {
        die("Prepare hatası: " . $baglanti->error);
    }

    $stmt->bind_param("ssssi", $ad_soyad, $email, $telefon, $adres, $kullanici_id);

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit;
    } else {
        echo "Bir hata oluştu: " . $stmt->error;
    }

    $stmt->close();
}

$baglanti->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>DEMAC</title>
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

  <script>
    let originalTitle = document.title;
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            document.title = "Bizi Unutma <3";
        } else {
            document.title = originalTitle;
        }
    });
  </script>
</head>
<body>

<?php 
$aktif_sayfa = 'profil';
include("header.php"); 
?>

<div class="container mt-5">
  <h2>Profilinizi Güncelleyin</h2>
  <div class="card mt-4">
    <div class="card-header">
      <h4 class="mb-0">Profil Bilgileri</h4>
    </div>
    <div class="card-body">
      <form id="updateProfileForm" method="POST">
        <div class="form-group">
          <label for="ad_soyad">İsim Soyisim</label>
          <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" value="<?php echo htmlspecialchars($kullanici['ad_soyad']); ?>" required>
        </div>
        <div class="form-group">
          <label for="email">E-posta</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($kullanici['email']); ?>" required>
        </div>
        <div class="form-group">
          <label for="telefon">Telefon</label>
          <input type="text" class="form-control" id="telefon" name="telefon" maxlength="15" placeholder="(5xx) xxx xx xx" value="<?php echo htmlspecialchars($kullanici['telefon']); ?>">
        </div>
        <div class="form-group">
          <label for="adres">Adres</label>
          <textarea class="form-control" id="adres" name="adres"><?php echo htmlspecialchars($kullanici['adres']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #E4256C;">Güncelle</button>
      </form>
    </div>
  </div>
</div>

<br><br><br><br><br><br><br>

<?php include("info.php"); ?>

<script>
  // Telefon maskesi
  document.getElementById('telefon').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Rakam dışı karakterleri temizle
    if (value.length > 10) value = value.slice(0, 10); // Maksimum 10 rakam

    let formatted = '';
    if (value.length > 0) {
      formatted += '(' + value.substring(0, 3);
    }
    if (value.length >= 3) {
      formatted += ') ' + value.substring(3, 6);
    }
    if (value.length >= 6) {
      formatted += ' ' + value.substring(6, 8);
    }
    if (value.length >= 8) {
      formatted += ' ' + value.substring(8, 10);
    }

    e.target.value = formatted;
  });

  // Arama kutusu göster/gizle
  const searchBtn = document.getElementById('searchBtn');
  const searchBox = document.getElementById('searchBox');

  searchBtn.addEventListener('mouseover', function () {
    searchBox.style.display = 'block';
  });

  searchBox.addEventListener('mouseover', function () {
    searchBox.style.display = 'block';
  });

  searchBox.addEventListener('mouseout', function (event) {
    if (!searchBox.contains(event.relatedTarget) && event.relatedTarget !== searchBtn) {
      searchBox.style.display = 'none';
    }
  });
</script>

</body>
</html>
