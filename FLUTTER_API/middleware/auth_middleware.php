<?php
require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authenticate() {
    // Ambil header Authorization
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    // Cek apakah token ada
    if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(["status" => false, "message" => "Token tidak ditemukan"]);
        exit;
    }

    $jwt = $matches[1];
    $key = "SECRET_KEY_ANDA"; // HARUS SAMA dengan yang di login.php

    try {
        // Dekode token
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded; // Token valid, kembalikan data user
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["status" => false, "message" => "Token tidak valid: " . $e->getMessage()]);
        exit;
    }
}
?>