<?php
// Mulai session
session_start();
// Jika user sudah login, arahkan ke login
if (isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 20px;
            background-color: rgb(60, 64, 52);
            color: orange;
        }
        .navbar h1 {
            margin: 0;
            font-size: 30px;
            text-align: center;
        }
        .background-container {
            position: relative;
            width: 100%;
            height: 600px;
            background: url('images12/1ih4guthrhg.jpg') no-repeat center center;
            background-size: cover;
        }
        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: yellow;
            background-color: rgba(0, 0, 0, 0.08); /* Memberikan efek gelap pada gambar latar */
        }
        .content-overlay h2, .content-overlay a, .content-overlay marquee {
            margin: 10px 0;
        }
        .content-overlay a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background-color: blue;
            border-radius: 5px;
        }
        .content-overlay a:hover {
            background-color: green;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>ADCONNIE Web Perpustakaan</h1>
    </div>

    <!-- Gambar Latar dengan Konten Utama -->
    <div class="background-container">
        <div class="content-overlay">
            <h2><strong>Selamat Datang di ADCONNIE Web Perpustakaan</strong></h2>
            <a href="login.php" class="btn btn-primary">Login</a>
            <h2>
                <marquee>Silakan login untuk mengakses Web Perpustakaan</marquee>
            </h2>
        </div>
    </div>
</body>
</html>