<?php
session_start();

// Kullanıcı oturum kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

try {
    include("veritabani.php");

    $stmt = $baglanti->prepare("SELECT * FROM kullanicilar WHERE kullanici_id = ? LIMIT 1");
    $stmt->bind_param("i", $kullanici_id);
    $stmt->execute();
    $sonuc = $stmt->get_result();
    $kullanici = $sonuc->fetch_assoc();

} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
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
  <link href="css/odeme.css" rel="stylesheet" />
  </head>
  <body>
<?php 
include("header.php"); 
echo "<br>";
?>
  

<h2 style="text-align: center;">Ödeme ve Adres Bilgileri</h2>

<form action="order_confirmation.php" method="POST">
    <div class="form-group">
        <label for="ad_soyad">Adınız ve Soyadınız:</label>
        <input type="text" id="ad_soyad" name="ad_soyad" required 
            value="<?= isset($kullanici['ad_soyad']) ? htmlspecialchars($kullanici['ad_soyad']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="email">E-posta Adresiniz:</label>
        <input type="email" id="email" name="email" required 
            value="<?= isset($kullanici['email']) ? htmlspecialchars($kullanici['email']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="telefon">Telefon:</label>
        <input type="tel" id="telefon" name="telefon" required 
            value="<?= isset($kullanici['telefon']) ? htmlspecialchars($kullanici['telefon']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="adres">Adres:</label>
        <textarea id="adres" name="adres" required><?= isset($kullanici['adres']) ? htmlspecialchars($kullanici['adres']) : '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="odeme">Ödeme Yöntemi:</label>
        <select id="odeme" name="odeme" required>
            <option value="kredi_karti" <?= isset($kullanici['odeme_yontemi']) && $kullanici['odeme_yontemi'] == 'kredi_karti' ? 'selected' : '' ?>>Kredi Kartı</option>
            <option value="kapida_odeme" <?= isset($kullanici['odeme_yontemi']) && $kullanici['odeme_yontemi'] == 'kapida_odeme' ? 'selected' : '' ?>>Kapıda Ödeme</option>
        </select>
    </div>

    <!-- Kart bilgileri sadece kredi kartı seçildiğinde gösterilecek -->
    <div id="kart-bilgileri">
        <div class="form-group">
            <label for="kart_numarasi">Kart Numarası:</label>
            <input type="text" id="kart_numarasi" name="kart_numarasi" placeholder="Örn: 4242 4242 4242 4242">
        </div>

        <div class="form-group">
            <label for="son_kullanma">Son Kullanma Tarihi (AA/YY):</label>
            <input type="text" id="son_kullanma" name="son_kullanma" placeholder="Örn: 12/26">
        </div>

        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" placeholder="Örn: 123">
        </div>
    </div>

    <button type="submit" class="confirm-btn" style="background-color: #E4256C;">Siparişi Onayla</button>
</form>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const odemeSecimi = document.getElementById("odeme");
    const kartBilgileri = document.getElementById("kart-bilgileri");
    const kartNumarasiInput = document.getElementById("kart_numarasi");
    const sonKullanmaInput = document.getElementById("son_kullanma");
    const cvvInput = document.getElementById("cvv");
    const telefonInput = document.getElementById("telefon");
    const kartInputlari = kartBilgileri.querySelectorAll("input");

    function kartBilgileriniGosterGizle() {
        if (odemeSecimi.value === "kredi_karti") {
            kartBilgileri.style.display = "block";
            kartInputlari.forEach(input => input.setAttribute("required", "required"));
        } else {
            kartBilgileri.style.display = "none";
            kartInputlari.forEach(input => input.removeAttribute("required"));
        }
    }

    kartBilgileriniGosterGizle();
    odemeSecimi.addEventListener("change", kartBilgileriniGosterGizle);

    // Kart numarası: 12 hane, 4'erli gruplar
    kartNumarasiInput.addEventListener("input", function () {
        let value = this.value.replace(/[^\d]/g, "").slice(0, 12);
        value = value.replace(/(.{4})/g, "$1 ").trim();
        this.value = value;
    });

    // CVV: sadece 3 rakam
    cvvInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^\d]/g, "").slice(0, 3);
    });

    // Son kullanma tarihi: AA/YY formatı
sonKullanmaInput.addEventListener("input", function () {
    let value = this.value.replace(/[^\d]/g, "").slice(0, 4); // Sadece 4 rakam, örn: 1225

    if (value.length >= 1) {
        // İlk rakam 2'den büyükse 0 ile başlat
        if (parseInt(value[0]) > 1) {
            value = "0" + value[0];
        }
    }

    if (value.length >= 2) {
        let ay = parseInt(value.slice(0, 2));
        // Ay 1-12 arasında değilse düzelt
        if (ay < 1) {
            value = "01" + value.slice(2);
        } else if (ay > 12) {
            value = "12" + value.slice(2);
        }
    }

    if (value.length > 2) {
        this.value = value.slice(0, 2) + "/" + value.slice(2);
    } else {
        this.value = value;
    }
});


    // Telefon numarası (555)555 55 55
    telefonInput.addEventListener("input", function () {
        let value = this.value.replace(/[^\d]/g, "").slice(0, 10);
        let formatted = "";

        if (value.length > 0) {
            formatted = "(" + value.substring(0, 3);
        }
        if (value.length >= 3) {
            formatted += ") " + value.substring(3, 6);
        }
        if (value.length >= 6) {
            formatted += " " + value.substring(6, 8);
        }
        if (value.length >= 8) {
            formatted += " " + value.substring(8, 10);
        }

        this.value = formatted;
    });

   
});
</script>
</body>
</html>