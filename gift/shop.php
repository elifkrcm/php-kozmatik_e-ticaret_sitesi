<?php
include("veritabani.php");

// Kategorileri ve markaları dinamik olarak veritabanından çek
$kategori_sorgu = "SELECT DISTINCT kategori FROM urunler";
$kategori_sonuc = $baglanti->query($kategori_sorgu);

$marka_sorgu = "SELECT DISTINCT marka FROM urunler";
$marka_sonuc = $baglanti->query($marka_sorgu);

// GET ile gelen filtreler
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : "";
$marka = isset($_GET['marka']) ? $_GET['marka'] : "";
$sirala = isset($_GET['sirala']) ? $_GET['sirala'] : "";

// Ürünleri çekmek için temel sorgu
$query = "SELECT * FROM urunler";
$parameters = [];
$conditions = [];

// Filtre koşulları
if (!empty($kategori)) {
    $conditions[] = "kategori = ?";
    $parameters[] = $kategori;
}
if (!empty($marka)) {
    $conditions[] = "marka = ?";
    $parameters[] = $marka;
}

// Koşulları birleştir
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

// Sıralama işlemleri
if (!empty($sirala)) {
    switch ($sirala) {
        case 'a_to_z':
            $query .= " ORDER BY urun_adi ASC";
            break;
        case 'z_to_a':
            $query .= " ORDER BY urun_adi DESC";
            break;
        case 'cheap_to_expensive':
            $query .= " ORDER BY urun_fiyat ASC";
            break;
        case 'expensive_to_cheap':
            $query .= " ORDER BY urun_fiyat DESC";
            break;
        case 'new_to_old':
            $query .= " ORDER BY urun_id DESC";
            break;
        case 'old_to_new':
            $query .= " ORDER BY urun_id ASC";
            break;
    }
}

// Sorguyu çalıştır
$stmt = $baglanti->prepare($query);
if (!empty($parameters)) {
    $stmt->bind_param(str_repeat("s", count($parameters)), ...$parameters);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/shop.css">
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>DEMAC</title>
  <script>
    let originalTitle = document.title;
    document.addEventListener('visibilitychange', function() {
        document.title = document.hidden ? "Bizi Unutma <3" : originalTitle;
    });
  </script>
</head>
<body>

<?php 
$aktif_sayfa = 'shop';
include("header.php"); 
?>

<br>

<!-- Filtreleme Formu -->
<form method="GET" action="" class="kategori-form">
  <label for="kategori">Kategori:</label>
  <select name="kategori" id="kategori">
      <option value="">Tüm Kategoriler</option>
      <?php 
      while ($kat = $kategori_sonuc->fetch_assoc()) {
          $secili = ($kategori == $kat['kategori']) ? "selected" : "";
          echo "<option value='" . htmlspecialchars($kat['kategori']) . "' $secili>" . htmlspecialchars($kat['kategori']) . "</option>";
      }
      ?>
  </select>

  <label for="marka">Marka:</label>
  <select name="marka" id="marka">
      <option value="">Tüm Markalar</option>
      <?php 
      while ($m = $marka_sonuc->fetch_assoc()) {
          $secili = ($marka == $m['marka']) ? "selected" : "";
          echo "<option value='" . htmlspecialchars($m['marka']) . "' $secili>" . htmlspecialchars($m['marka']) . "</option>";
      }
      ?>
  </select>

  <label for="sirala">Sıralama:</label>
  <select name="sirala" id="sirala">
      <option value="">Sıralama Seçin</option>
      <option value="a_to_z" <?php echo ($sirala == "a_to_z") ? "selected" : ""; ?>>A'dan Z'ye</option>
      <option value="z_to_a" <?php echo ($sirala == "z_to_a") ? "selected" : ""; ?>>Z'den A'ya</option>
      <option value="cheap_to_expensive" <?php echo ($sirala == "cheap_to_expensive") ? "selected" : ""; ?>>Ucuzdan Pahalıya</option>
      <option value="expensive_to_cheap" <?php echo ($sirala == "expensive_to_cheap") ? "selected" : ""; ?>>Pahalıdan Ucuza</option>
      <option value="new_to_old" <?php echo ($sirala == "new_to_old") ? "selected" : ""; ?>>Yeniden Eskiye</option>
      <option value="old_to_new" <?php echo ($sirala == "old_to_new") ? "selected" : ""; ?>>Eskiden Yeniye</option>
  </select>

  <button type="submit">Filtrele</button>
</form>

<!-- Ürün Listeleme -->
<div class="urunler-container">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='urun'>";
        echo "<a href='detay.php?urun_id=" . $row['urun_id'] . "'>";
        echo "<img src='" . $row['resim_url'] . "' alt='" . htmlspecialchars($row['urun_adi']) . "'>";
        echo "</a>";
        echo "<div class='urun-detay'>";
        echo "<h2><b>" . htmlspecialchars($row['marka']) . "</b></h2>";
        echo "<h2>" . htmlspecialchars($row['urun_adi']) . "</h2>";
        echo "<p><strong>Fiyat:</strong> " . $row['urun_fiyat'] . " TL</p>";

        // Ortalama puanı getir
        $urun_id = $row['urun_id'];
        $puanStmt = $baglanti->prepare("SELECT AVG(puan) as average_rating FROM yorumlar WHERE urun_id = ?");
        $puanStmt->bind_param("i", $urun_id);
        $puanStmt->execute();
        $puanlar = $puanStmt->get_result()->fetch_assoc();
        $ortalama_puan = $puanlar['average_rating'] ? round($puanlar['average_rating'], 1) : 0;

        // Yıldız gösterimi
        echo "<div class='stars'>";
        for ($i = 0; $i < floor($ortalama_puan); $i++) echo "<i class='fa fa-star'></i>";
        if ($ortalama_puan - floor($ortalama_puan) >= 0.5) echo "<i class='fa fa-star-half-o'></i>";
        for ($i = 0; $i < (5 - ceil($ortalama_puan)); $i++) echo "<i class='fa fa-star-o'></i>";
        echo "</div>";

        echo "</div>"; // urun-detay
        echo "</div>"; // urun
    }
} else {
    echo "<p>Filtrenize uyan ürün bulunamadı.</p>";
}
$baglanti->close();
?>
</div>

<br><br><br><br><br><br>

<?php include("info.php"); ?>

<script src="js/script.js"></script>
</body>
</html>
