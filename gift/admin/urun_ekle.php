<?php
include("baglanti.php");
include("navbar.php");
if ($_POST) {
    $adi = $_POST["urun_adi"];
    $kategori = $_POST["kategori"];
    $marka = $_POST["marka"];
    $fiyat = $_POST["urun_fiyat"];
    $stok = $_POST["stok_adedi"];
    $aciklama = $_POST["aciklama"];
    $resim = $_POST["resim_url"];

    $sorgu = $baglanti->prepare("INSERT INTO urunler 
        (urun_adi, kategori, marka, urun_fiyat, stok_adedi, aciklama, resim_url) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sorgu->execute([$adi, $kategori, $marka, $fiyat, $stok, $aciklama, $resim]);

    echo "<br><div class='mesaj'>Ürün başarıyla eklendi 💖<br><a href='urunler.php'>Listeye dön</a></div>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	
    <meta charset="UTF-8">
    <title>Ürün Ekle</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            color: #3f4a63;
            margin-bottom: 30px;
        }

        form input, form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3f4a63;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #57606f;
        }

        .mesaj {
            background-color: #dff9fb;
            color: #130f40;
            padding: 15px;
            margin: 20px auto;
            border-radius: 8px;
            text-align: center;
            width: 400px;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        a {
            color: #6c5ce7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Yeni Ürün Ekle</h2>
    <form method="post">
        <input name="urun_adi" placeholder="Ürün adı" required>
        <input name="kategori" placeholder="Kategori" required>
        <input name="marka" placeholder="Marka">
        <input type="number" step="0.01" name="urun_fiyat" placeholder="Fiyat" required>
        <input type="number" name="stok_adedi" placeholder="Stok" required>
        <textarea name="aciklama" placeholder="Açıklama"></textarea>
        <input name="resim_url" placeholder="Resim URL (isteğe bağlı)">
        <button type="submit">Kaydet</button>
    </form>
</div>

</body>
</html>
