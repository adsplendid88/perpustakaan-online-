<?php
$host = 'localhost'; // Host server database
$dbname = 'perpustakaan'; // Nama database Anda
$username = 'root'; // Username database (sesuaikan)
$password = ''; // Password database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Uji koneksi
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
} else {
    echo 'Koneksi berhasil!';
}
?>

