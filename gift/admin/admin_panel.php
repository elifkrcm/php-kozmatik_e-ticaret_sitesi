<?php
session_start();
if (!isset($_SESSION["admin_giris"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="admin_style.css">
    
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <ul>
			<li><a href="admin_panel.php">Anasayfa</a></li>
            <li><a href="urunler.php">Ürünler</a></li>
            <li><a href="kullanici_listeleme.php">Kullanıcılar</a></li>
            <li><a href="siparis_listele.php">Siparişler</a></li>
            <li><a href="yorumlar.php">Yorumlar</a></li>
            
            <li><a href="admin_exit.php">Çıkış Yap</a></li>
        </ul>
    </div>

    

    <!-- Sayfa İçeriği -->
    <div class="main-content">
        <h1>Hoş geldin Admin</h1>
        <p>Paneli kullanarak tüm sistemini kolayca yönetebilirsin.</p>
    </div>

</body>
</html>
