<?php
session_start();
session_destroy(); // Menghapus sesi login
header("Location: login.php"); // Redirect ke halaman login 
exit;
?>
