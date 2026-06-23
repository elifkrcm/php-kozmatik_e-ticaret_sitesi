<?php
session_start();
if (!isset($_SESSION["admin_giris"])) {
    header("Location: admin_login.php");
    exit();
}
include("baglanti.php");
include("navbar.php");
// Kategori ve marka verileri
$kategori_sorgu = $baglanti->query("SELECT DISTINCT kategori FROM urunler");
$marka_sorgu = $baglanti->query("SELECT DISTINCT marka FROM urunler");

$kategori_id = $_GET['kategori_id'] ?? '';
$marka = $_GET['marka'] ?? '';
$sira = $_GET['sira'] ?? '';

$query = "SELECT * FROM urunler WHERE 1";

$params = [];
if ($kategori_id) {
    $query .= " AND kategori = ?";
    $params[] = $kategori_id;
}
if ($marka) {
    $query .= " AND marka = ?";
    $params[] = $marka;
}
if ($sira == 'azdan-cok') $query .= " ORDER BY urun_fiyat ASC";
elseif ($sira == 'coktan-aza') $query .= " ORDER BY urun_fiyat DESC";
elseif ($sira == 'a-z') $query .= " ORDER BY urun_adi ASC";
elseif ($sira == 'z-a') $query .= " ORDER BY urun_adi DESC";

$sorgu = $baglanti->prepare($query);
$sorgu->execute($params);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürünler</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 70px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 0 25px rgba(0,0,0,0.06);
        }

        h2 {
            text-align: center;
            color: #3f4a63;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        select, button {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            background-color: #bdcadb;
            color: black;
            border: none;
            transition: 0.3s;
        }

        button:hover {
            background-color: #2f3542;
			color: white;
        }

        .btn {
            padding: 6px 12px;
            margin: 2px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 13px;
        }

        .ekle-btn { background-color: #43a047;  }
        .duzenle-btn { background-color: #bdcadb; color:black;}
        .sil-btn { background-color: #e53935; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
			border-radius: 10px;
			overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
			vertical-align: middle;
        }

        th {
            background-color: #3f4a63;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .top-right {
            text-align: right;
            margin-bottom: 15px;
        }

        img {
            border-radius: 6px;
        }
		
		.butonlar {
			
			justify-content: center;
			gap: 6px;
			align-items: center;
		}

		.butonlar .btn {
			margin: 0;
			white-space: nowrap;
			padding: 6px 8px;
			font-size: 13px;
			line-height: 3;
		}
    </style>
</head>
<body>

<div class="container">
    <h2>Ürün Listesi</h2>

    <div class="top-right">
        <a href="urun_ekle.php" class="btn ekle-btn">+ Yeni Ürün Ekle</a>
    </div>

    <form method="get" action="urunler.php">
        <select name="kategori_id">
            <option value="">Tüm Kategoriler</option>
            <?php foreach ($kategori_sorgu as $kategori): ?>
                <option value="<?= $kategori["kategori"] ?>" <?= ($kategori["kategori"] == $kategori_id) ? 'selected' : '' ?>>
                    <?= $kategori["kategori"] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="marka">
            <option value="">Tüm Markalar</option>
            <?php foreach ($marka_sorgu as $marka_option): ?>
                <option value="<?= $marka_option["marka"] ?>" <?= ($marka_option["marka"] == $marka) ? 'selected' : '' ?>>
                    <?= $marka_option["marka"] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sira">
            <option value="">Sıralama</option>
            <option value="azdan-cok" <?= ($sira == 'azdan-cok') ? 'selected' : '' ?>>Fiyat: Ucuzdan Pahalıya</option>
            <option value="coktan-aza" <?= ($sira == 'coktan-aza') ? 'selected' : '' ?>>Fiyat: Pahalıdan Ucuza</option>
            <option value="a-z" <?= ($sira == 'a-z') ? 'selected' : '' ?>>A'dan Z'ye</option>
            <option value="z-a" <?= ($sira == 'z-a') ? 'selected' : '' ?>>Z'den A'ya</option>
        </select>

        <button type="submit">Filtrele</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Adı</th>
            <th>Kategori</th>
            <th>Marka</th>
            <th>Fiyat</th>
            <th>Stok</th>
            <th>Resim</th>
            <th>İşlem</th>
        </tr>
        <?php foreach ($sorgu as $urun): ?>
            <tr>
                <td><?= $urun["urun_id"] ?></td>
                <td><?= $urun["urun_adi"] ?></td>
                <td><?= $urun["kategori"] ?></td>
                <td><?= $urun["marka"] ?></td>
                <td><?= $urun["urun_fiyat"] ?> TL</td>
                <td><?= $urun["stok_adedi"] ?></td>
                <td>
                    <?php if ($urun["resim_url"]): ?>
                        <img src="<?= $urun["resim_url"] ?>" width="50">
                    <?php else: ?>
                        Yok
                    <?php endif; ?>
                </td>
                <td class="butonlar">
                    <a href="urun_duzenle.php?id=<?= $urun["urun_id"] ?>" class="btn duzenle-btn">Düzenle</a>
                    <a href="urun_sil.php?id=<?= $urun["urun_id"] ?>" class="btn sil-btn" onclick="return confirm('Ürünü silmek istediğinize emin misiniz?')">Sil</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
