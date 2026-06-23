<?php

include("veritabani.php");

$mesaj = ""; // Hata ya da uyarı mesajı için

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["kayit"])) {
    $ad_soyad = $_POST['ad_soyad'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];

    if (!preg_match('/^(?=.*[A-Z]).{8,}$/', $sifre)) {
        $mesaj = "Şifre en az 8 karakter uzunluğunda ve en az bir büyük harf içermelidir.";
    } elseif ($sifre !== $sifre_tekrar) {
        $mesaj = "Şifreler eşleşmiyor.";
    } else {
        $kontrol = $baglanti->prepare("SELECT kullanici_id FROM kullanicilar WHERE email = ?");
        $kontrol->bind_param("s", $email);
        $kontrol->execute();
        $kontrol->store_result();

        if ($kontrol->num_rows > 0) {
            $mesaj = "Bu email adresi zaten kayıtlı.";
        } else {
            $sifre_hashli = password_hash($sifre, PASSWORD_DEFAULT);
            $stmt = $baglanti->prepare("INSERT INTO kullanicilar (ad_soyad, email, sifre) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $ad_soyad, $email, $sifre_hashli);

            if ($stmt->execute()) {
                header("Location: giris.php");
                exit();
            } else {
                $mesaj = "Kayıt sırasında bir hata oluştu: " . $stmt->error;
            }
            $stmt->close();
        }
        $kontrol->close();
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

  <!-- Bootstrap and custom stylesheets -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/giris.css" />

  <script>
    // Şifreyi gösterme/gizleme
    function togglePassword() {
        var passwordField = document.getElementById("sifre");
        var repeatPasswordField = document.getElementById("sifre_tekrar");
        var passwordVisibility = document.getElementById("passwordVisibility");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            repeatPasswordField.type = "text";
            passwordVisibility.textContent = "Şifreyi Gizle";
        } else {
            passwordField.type = "password";
            repeatPasswordField.type = "password";
            passwordVisibility.textContent = "Şifreyi Göster";
        }
    }

    // Şifre doğrulama
    function validatePassword() {
        const sifre = document.getElementById('sifre').value;
        const sifreTekrar = document.getElementById('sifre_tekrar').value;
        const uyari = document.getElementById('sifreUyari');

        if (!/^(?=.*[A-Z]).{8,}$/.test(sifre)) {
            uyari.textContent = "Şifre en az 8 karakter olmalı ve en az bir büyük harf içermeli.";
            return false;
        } else if (sifre !== sifreTekrar) {
            uyari.textContent = "Şifreler eşleşmiyor.";
            return false;
        }

        uyari.textContent = "";
        return true;
    }
  </script>
</head>

<body>

<?php 
$aktif_sayfa = 'giris';
include("header.php"); 
?>

<br><br>
<section class="auth-container">
    <div class="form-box">

        <!-- Mesaj gösterimi -->
        <?php if (!empty($mesaj)) : ?>
            <div style="color: red; font-weight: bold;"><?php echo $mesaj; ?></div>
        <?php endif; ?>

        <h2>Kayıt Ol</h2>

        <form action="" method="POST" onsubmit="return validatePassword();">
            <input type="text" name="ad_soyad" placeholder="Ad Soyad" required
                   value="<?php echo isset($_POST['ad_soyad']) ? htmlspecialchars($_POST['ad_soyad']) : ''; ?>">

            <input type="email" name="email" placeholder="E-posta" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <input type="password" id="sifre" name="sifre" placeholder="Şifre" required>
            <input type="password" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifreyi Tekrar" required>

            <span id="sifreUyari" style="color: red; font-size: 12px;"></span>

            <div>
                <input type="checkbox" onclick="togglePassword()"> Şifreyi Göster
            </div>

            <button type="submit" name="kayit" style="background-color: #E4256C;">Kayıt Ol</button>
        </form>

        <p>Zaten hesabınız var mı? <a href="giris.php">Giriş Yap</a></p>
    </div>
</section>
<br><br><br><br><br><br>
<?php include("info.php"); ?>

<script src="js/script.js"></script>

</body>
</html>
