<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username']; // Ambil username dari session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between; /* Membuat layout kiri-kanan */
            align-items: center; /* Vertikal center */
            padding: 10px 20px;
            background-color: #343a40;
            color: white;
        }
        .navbar h1 {
            margin: 0;
            font-size: 30px; /* Ukuran font yang lebih besar */
            text-align: center;
            flex-grow: 1; /* Memastikan judul ada di tengah */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background-color: red;
            border-radius: 5px;
        }
        .navbar a:hover {
            background-color: #800020;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Dashboard Perpustakaan</h1>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container mt-5">
        <h2>Daftar Item Perpustakaan</h2>
        <a href="create.php" class="btn btn-primary mb-3">Tambah Item</a>
        <table class="table">
            <thead>
                <tr>
                    <th> NO </th>
                    <th>Nama Buku & Penulis </th>
                    <th>Jenis Buku / Genre</th>
                    <th>Jumlah</th> 
                </tr>
            </thead>
            <tbody>

                <?php
                include 'config.php';
                $sql = "SELECT * FROM items";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $no=1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td> {$no}</td>   
                                <td>{$row['name_item']}</td>
                                <td>{$row['jenis_item']}</td>
                                <td>{$row['jumlah']}</td>
                        <td> 
                                    <a href='update.php?id={$row['id_name']}' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='delete.php?id={$row['id_name']}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                            </tr>";
                            $no++; 
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
