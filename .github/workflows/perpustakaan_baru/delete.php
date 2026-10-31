<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
$id = $_GET['id'];

// Konfirmasi hapus
if (isset($_GET['konfirmasi'])) {
    $stmt = $conn->prepare("DELETE FROM items WHERE id_name = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Item berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus item.";
    }
    header("Location: dashboard.php");
    exit;
}

// Tampilkan konfirmasi hapus
$stmt = $conn->prepare("SELECT * FROM items WHERE id_name = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Konfirmasi Hapus Item</h2>
    <p>Apakah Anda yakin ingin menghapus item <?= $item['id_name']; ?>?</p>
    <a href="?id=<?= $id; ?>&konfirmasi=1" class="btn btn-danger">Hapus</a>
    <a href="dashboard.php" class="btn btn-secondary">Batal</a>
</div>
</body>
</html>