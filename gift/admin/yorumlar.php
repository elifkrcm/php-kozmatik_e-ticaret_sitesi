<?php
include('baglanti.php');
include("navbar.php");
// Filtreleme işlemi
$durum_filter = '';
if (isset($_GET['durum']) && in_array($_GET['durum'], ['Onaylı', 'Onaysız'])) {
    $durum_filter = $_GET['durum'];
    $query = "SELECT yorumlar.*, urunler.urun_adi, kullanicilar.ad_soyad 
              FROM yorumlar 
              JOIN urunler ON yorumlar.urun_id = urunler.urun_id 
              JOIN kullanicilar ON yorumlar.kullanici_id = kullanicilar.kullanici_id 
              WHERE yorumlar.durum = :durum
              ORDER BY yorumlar.tarih DESC";
    $stmt = $baglanti->prepare($query);
    $stmt->bindParam(':durum', $durum_filter);
} else {
    $query = "SELECT yorumlar.*, urunler.urun_adi, kullanicilar.ad_soyad 
              FROM yorumlar 
              JOIN urunler ON yorumlar.urun_id = urunler.urun_id 
              JOIN kullanicilar ON yorumlar.kullanici_id = kullanicilar.kullanici_id 
              ORDER BY yorumlar.tarih DESC";
    $stmt = $baglanti->prepare($query);
}

$stmt->execute();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yorum Yönetimi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

		.container {
            max-width: 1100px;
            margin: 70px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,0,0,0.06);
        }
        h1 {
            text-align: center;
            color: #3f4a63;
            margin:20px auto;
        }

        .filter-buttons {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-buttons a {
            display: inline-block;
            background-color: #3f4a63;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin: 0 5px;
            font-weight: bold;
        }

        .filter-buttons a:hover {
            background-color: #5a6b8d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        thead {
            background-color: #3f4a63;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: inherit;
        }

        select {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #3f4a63;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        button:hover {
            background-color: #5a6b8d;
        }

        a.delete {
            color: #c0392b;
            text-decoration: none;
            font-weight: bold;
        }

        a.delete:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                border-radius: 10px;
                background-color: #fff;
                padding: 10px;
            }

            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
<div class="container">
<h1>Yorum Yönetimi</h1>

<div class="filter-buttons">
    <a href="yorumlar.php">Tüm Yorumlar</a>
    <a href="yorumlar.php?durum=Onaylı">Sadece Onaylı</a>
    <a href="yorumlar.php?durum=Onaysız">Sadece Onaysız</a>
</div>

<table>
    <thead>
        <tr>
            <th>Yorum ID</th>
            <th>Ürün Adı</th>
            <th>Kullanıcı Adı</th>
            <th>Yorum</th>
            <th>Puan</th>
            <th>Durum</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $row['yorum_id']; ?></td>
            <td><?php echo htmlspecialchars($row['urun_adi']); ?></td>
            <td><?php echo htmlspecialchars($row['ad_soyad']); ?></td>
            <td><?php echo substr(htmlspecialchars($row['yorum']), 0, 100); ?>...</td>
            <td><?php echo $row['puan']; ?></td>
            <td>
                <form action="yorum_onayla.php" method="POST">
                    <input type="hidden" name="yorum_id" value="<?php echo $row['yorum_id']; ?>">
                    <select name="durum">
                        <option value="Onaysız" <?php echo ($row['durum'] == 'Onaysız' ? 'selected' : ''); ?>>Onaysız</option>
                        <option value="Onaylı" <?php echo ($row['durum'] == 'Onaylı' ? 'selected' : ''); ?>>Onaylı</option>
                    </select>
                    <br>
                    <button type="submit">Güncelle</button>
                </form>
            </td>
            <td><a href="yorum_sil.php?yorum_id=<?php echo $row['yorum_id']; ?>" class="delete" onclick="return confirm('Yorumu silmek istediğinize emin misiniz?');">Sil</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>
