<?php
include("baglanti.php");
include("navbar.php");
// Kullanıcıları sıralama
$sort_order = 'ASC'; // Varsayılan sıralama A-Z
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'desc') {
        $sort_order = 'DESC'; // Z-A sıralama
    }
}

// Harf filtresi
$harf = isset($_GET['harf']) ? $_GET['harf'] : '';

$kullanici_sorgu = $baglanti->prepare("SELECT * FROM kullanicilar WHERE ad_soyad LIKE ? ORDER BY ad_soyad $sort_order");
$kullanici_sorgu->execute([$harf . '%']);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcılar</title>
    <style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        height: 100vh;
    }

    .table-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        width: 100%;
        max-width: 1000px;
        position: relative;
		margin:auto;
		
    }

    h2 {
        text-align: center;
        color: #3f4a63;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
		
    }

    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
    }

    th {
        background-color: #bdcadb;
        color: #243c5a;
        font-weight: bold;
    }

    td {
        background-color: #f4f6f9;
    }

    tr:nth-child(even) {
        background-color: #f4f6f9;
    }

    tr:hover {
        background-color: #e2e2f0;
    }

    .sort-button {
        background-color: #3f4a63;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        margin-top: 20px;
        display: inline-block;
    }

    .sort-button:hover {
        background-color: #1c3049;
    }

    /* Alfabe sağda ve scrollable */
    .alphabet {
        position: fixed;
        right: 0;
        top: 100px;
        width: 60px;
        height: 80%;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 10px;
        overflow-y: scroll;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }

    .alphabet a {
        color: #243c5a;
        display: block;
        margin-bottom: 10px;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .alphabet a:hover {
        color: #1c3049;
    }

    /* Geliştirilmiş scrollbar */
    .alphabet::-webkit-scrollbar {
        width: 12px; /* Scrollbar genişliği */
    }

    .alphabet::-webkit-scrollbar-thumb {
        background-color: #243c5a; /* Thumb (işaretçi) rengi */
        border-radius: 10px;
        border: 3px solid #e8e8ff; /* Kenarları daha net yapmak için */
    }

    .alphabet::-webkit-scrollbar-track {
        background-color: #f2f0fc; /* Scrollbar yolu */
        border-radius: 10px;
    }

</style>

</head>
<body>

<div class="table-container">
    <h2>Kullanıcılar</h2>

    <!-- A-Z Z-A Sıralama Butonları -->
    <a href="?sort=asc" class="sort-button">A-Z Sırala</a>
    <a href="?sort=desc" class="sort-button">Z-A Sırala</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ad Soyad</th>
                <th>E-posta</th>
                <th>Telefon</th>
                <th>Adres</th>
                <th>Kayıt Tarihi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kullanici_sorgu as $kullanici): ?>
                <tr>
                    <td><?= $kullanici['kullanici_id'] ?></td>
                    <td><?= $kullanici['ad_soyad'] ?></td>
                    <td><?= $kullanici['email'] ?></td>
                    <td><?= $kullanici['telefon'] ?></td>
                    <td><?= $kullanici['adres'] ? $kullanici['adres'] : 'Adres belirtilmemiş' ?></td>
                    <td><?= $kullanici['kayit_tarihi'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Türk Alfabesi -->
<div class="alphabet">
    <?php
    $turkce_alfabe = ['A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'];
    foreach ($turkce_alfabe as $harf_sec):
    ?>
        <a href="?harf=<?= $harf_sec ?>"><?= $harf_sec ?></a>
    <?php endforeach; ?>
</div>

</body>
</html>
