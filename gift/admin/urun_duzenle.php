<?php
include("baglanti.php");
include("navbar.php");
$id = $_GET["id"];
$sorgu = $baglanti->prepare("SELECT * FROM urunler WHERE urun_id = ?");
$sorgu->execute([$id]);
$urun = $sorgu->fetch();

if (!$urun) {
    echo "Ürün bulunamadı.";
    exit();
}

if ($_POST) {
    $adi = $_POST["urun_adi"];
    $kategori = $_POST["kategori"];
    $marka = $_POST["marka"];
    $fiyat = $_POST["urun_fiyat"];
    $stok = $_POST["stok_adedi"];
    $aciklama = $_POST["aciklama"];
    $resim = $_POST["resim_url"];

    $guncelle = $baglanti->prepare("UPDATE urunler SET 
        urun_adi = ?, kategori = ?, marka = ?, urun_fiyat = ?, stok_adedi = ?, aciklama = ?, resim_url = ?
        WHERE urun_id = ?");
    $guncelle->execute([$adi, $kategori, $marka, $fiyat, $stok, $aciklama, $resim, $id]);

    echo "<br><br>Ürün başarıyla güncellendi 💖 <br><a href='urunler.php'>Listeye dön</a>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Düzenle</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
			margin: 50px auto;
        }

        h2 {
            text-align: center;
            color: #3f4a63;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: white;
            font-size: 15px;
            box-sizing: border-box;
			color: #303033;

        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #3f4a63;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #57606f;
        }

        a {
            color: #243c5a;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Ürün Düzenle</h2>
    <form method="post">
        <input type="text" name="urun_adi" value="<?= $urun["urun_adi"] ?>" required>
        <input type="text" name="kategori" value="<?= $urun["kategori"] ?>" required>
        <input type="text" name="marka" value="<?= $urun["marka"] ?>">
        <input type="number" step="0.01" name="urun_fiyat" value="<?= $urun["urun_fiyat"] ?>" required>
        <input type="number" name="stok_adedi" value="<?= $urun["stok_adedi"] ?>" required>
        <textarea name="aciklama"><?= $urun["aciklama"] ?></textarea>
        <input type="url" name="resim_url" value="<?= $urun["resim_url"] ?>">
        <button type="submit">Güncelle</button>
    </form>
</div>

</body>
</html>
