<?php
session_start();
include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];

    $sorgu = $baglanti->prepare("SELECT * FROM admin WHERE email = ?");
    $sorgu->execute([$email]);
    $admin = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($sifre, $admin["sifre"])) {
        $_SESSION["admin_giris"] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $hata = "Hatalı e-posta veya şifre.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #3f4a63;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #3f4a63;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5a6b8d;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Paneli Girişi</h2>

    <?php if (isset($hata)): ?>
        <div class="error"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="email">E-posta:</label>
        <input type="email" name="email" id="email" required>

        <label for="sifre">Şifre:</label>
        <input type="password" name="sifre" id="sifre" required>

        <button type="submit">Giriş Yap</button>
    </form>
</div>

</body>
</html>
