<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
$id_name = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM items WHERE id_name = ?");
$stmt->bind_param('i', $id_name);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    // Jika item tidak ditemukan, tampilkan pesan kesalahan
    $_SESSION['error'] = "Item tidak ditemukan.";
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_item = $_POST['name_item'];
    $jenis_item = $_POST['jenis_item'];
    $jumlah = $_POST['jumlah'];

    $stmt = $conn->prepare("UPDATE items SET name_item = ?, jenis_item = ?, jumlah = ? WHERE id_name = ?");
    $stmt->bind_param('ssii', $name_item, $jenis_item, $jumlah, $id_name);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Item berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui item.";
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
    <title>Update Item - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Update Item</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name_item" class="form-label">Nama Buku & Penulis</label>
            <input type="text" class="form-control" id="name_item" name="name_item" value="<?= htmlspecialchars($item['name_item']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jenis_item" class="form-label">Jenis Buku</label>
            <input type="text" class="form-control" id="jenis_item" name="jenis_item" value="<?= htmlspecialchars($item['jenis_item']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Buku</label>
            <input type="integer" class="form-control" id="jumlah" name="jumlah" value="<?= $item['jumlah']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
    <?php 
    // Tampilkan data items dalam bentuk tabel
    $stmt = $conn->prepare("SELECT * FROM items");
    $stmt->execute();
    $items = $stmt->get_result();
    ?>
    <h2>Daftar Items</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Buku & Penulis</th>
                <th>Jenis Buku / Genre</th>
                <th>Jumlah Buku</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
            <tr>
                <td><?= $item['id_name']; ?></td>
                <td><?= $item['name_item']; ?></td>
                <td><?= $item['jenis_item']; ?></td>
                <td><?= $item['jumlah']; ?></td>
                <td>
                    <a href="update.php?id=<?= $item['id_name']; ?>" class="btn btn-sm btn-primary">Update</a>
                    <a href="delete.php?id=<?= $item['id_name']; ?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>



