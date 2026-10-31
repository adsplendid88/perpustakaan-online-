<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_item = $_POST['name_item'];
    $jenis_item = $_POST['jenis_item'];
    $jumlah = $_POST['jumlah'];

    $stmt = $conn->prepare("INSERT INTO items (name_item, jenis_item, jumlah) VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $name_item, $jenis_item, $jumlah);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Item berhasil ditambahkan.";
    } else {
        $_SESSION['error'] = "Gagal menambahkan item.";
    }
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Item - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Item Baru</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name_item" class="form-label">Nama Buku & Penulis</label>
            <input type="text" class="form-control" id="name_item" name="name_item" required>
        </div>
        <div class="mb-3">
            <label for="jenis_item" class="form-label">Jenis Buku</label>
            <input type="text" class="form-control" id="jenis_item" name="jenis_item" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Buku</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
