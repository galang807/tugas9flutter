<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/koneksi.php';
require_once '../helper/response.php';
require_once '../vendor/autoload.php';
require_once '../config/koneksi.php';
require_once '../helper/response.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    response(false, "Email dan password wajib diisi");
    exit;
}

// Cari user
$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE email='$email'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    response(false, "User tidak ditemukan");
    exit;
}

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    response(false, "Password salah");
    exit;
}

// JWT Secret Key
$key  = "FLUTTER_NATIVE_PHP_JWT_SECRET_KEY_2026_SUPER_SECURE_123456789";

// Payload JWT
$payload = [
    "id" => $user['id'],
    "email" => $user['email'],
    "exp" => time() + 3600
];

$token = JWT::encode(
    $payload,
    $key,
    'HS256'
);

// Generate Token
$token = JWT::encode(
    $payload,
    $key,
    'HS256'
);

// Response sukses
response(true, "Login berhasil", [
    "token" => $token,
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "email" => $user['email']
    ]
]);