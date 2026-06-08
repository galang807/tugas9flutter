<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "flutter_sesi9"; // Pastikan nama database ini sama dengan yang ada di phpMyAdmin [cite: 126]

$conn = new mysqli($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error); // Menangani kegagalan koneksi [cite: 128, 130]
}
?>