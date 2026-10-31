<?php
session_start();
include('config.php'); // Koneksi database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan password wajib diisi.';
        header('Location: login.php');
        exit();
    }
    // Query untuk mendapatkan data user berdasarkan username
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Kesalahan query: " . $conn->error);
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    // Jika user ditemukan
    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $users['password'])) {
            // Login sukses
            $_SESSION['username'] = $users['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            // Password salah
            $_SESSION['error'] = 'Password salah.';
            header('Location: login.php');
            exit();
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['error'] = 'Username tidak ditemukan.';
        header('Location: login.php');
        exit();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100%;
            margin: 0;
            background: url('img/login-background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login Perpustakaan</h2>
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                </form>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger mt-3">
                        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                    <small>Belum punya akun? <a href="register.php">Daftar sekarang</a></small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
