<?php
// Database connection
$host = "localhost"; // Ganti dengan nama host Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "perpustakaan"; // Ganti dengan nama database Anda
// Koneksi ke MySQL
$conn = new mysqli($host, $username, $password, $dbname);
// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = trim($_POST['username']);
    $pass = trim($_POST['password']);
    $confirm_pass = trim($_POST['confirm_password']);
    // Validasi
    if (empty($users) || empty($pass) || empty($confirm_pass)) {
        $error = "Semua field harus diisi.";
    } elseif ($pass !== $confirm_pass) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah ada
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("s", $users);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            // Hash password
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            // Simpan ke database
            $sql_insert = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("ss", $users, $hashed_password);
            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan. Coba lagi.";
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Sudah punya akun? Login</a>
        </form>
    </div>
</body>
</html>
