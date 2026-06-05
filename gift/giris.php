<?php
session_start();

include("veritabani.php");

// Giriş yapma işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["giris"])) {
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    $sql = "SELECT * FROM kullanicilar WHERE email = '$email'";
    $sonuc = $baglanti->query($sql);

    if ($sonuc->num_rows > 0) {
        $kullanici = $sonuc->fetch_assoc();
        if (password_verify($sifre, $kullanici['sifre'])) {
            $_SESSION['kullanici_id'] = $kullanici['kullanici_id'];
            $_SESSION['ad_soyad'] = $kullanici['ad_soyad'];
            // Hoş geldiniz mesajı yerine profil sayfasına yönlendirme yapıyoruz
            header("Location: profil.php"); 
            exit; // yönlendirmeden sonra diğer kodların çalışmasını engellemek için
        } else {
            echo "Şifre hatalı!";
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }
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
  <title>DEMAC</title>

  <script>
    // Şifreyi göster/gizle işlevi
    function togglePassword() {
      var passwordField = document.getElementById("sifre");
      var showPasswordCheckbox = document.getElementById("showPassword");
      
      if (showPasswordCheckbox.checked) {
        passwordField.type = "text";  // Şifreyi göster
      } else {
        passwordField.type = "password";  // Şifreyi gizle
      }
    }
  </script>

  <!-- Bootstrap and custom stylesheets -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/giris.css" />
</head>
<body>
<?php 
$aktif_sayfa = 'giris';
include("header.php"); 
?>

<br><br>
  
<section class="auth-container">
    <div class="form-box">
        <h2>Giriş Yap</h2>
        <!-- Giriş formu -->
        <form action="" method="POST">
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="sifre" id="sifre" placeholder="Şifre" required>
            
            <!-- Şifreyi gösterme checkbox -->
            <label>
                <input type="checkbox" id="showPassword" onclick="togglePassword()"> Şifreyi Göster
            </label>
            
            <button type="submit" name="giris" style="background-color: #E4256C;">Giriş Yap</button>
        </form>
        <p>Hesabınız yok mu? <a href="kayit.php">Kayıt Ol</a></p>
    </div>
</section>

<br><br><br><br><br><br><br><br>

<?php include("info.php"); ?>

<script src="js/script.js"></script>

</body>
</html>
