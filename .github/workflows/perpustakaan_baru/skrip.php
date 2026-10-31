<?php
// Konfigurasi koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";
// Koneksi ke MySQL
$conn = new mysqli($host, $user, $pass, $db);
// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Simpan ke database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
// Proses login
if (isset($_POST['login'])) {
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];
    // Ambil hash password dari database
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        // Verifikasi password
        if (password_verify($login_password, $hashed_password)) {
            echo "Login berhasil! Selamat datang, " . htmlspecialchars($login_username) . ".";
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
    $stmt->close();
}
$conn->close();
?>
<!-- Form HTML -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi dan Login</title>
</head>
<body>
    <h2>Form Registrasi</h2>
    <form method="POST" action="">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
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
    <h2>Form Login</h2>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100%;
            margin: 10;
            background: url('img/login-background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
    <form method="POST" action="">
        Username: <input type="text" name="login_username" required><br><br>
        Password: <input type="password" name="login_password" required><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
