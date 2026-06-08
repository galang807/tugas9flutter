<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
include "../config/koneksi.php";

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($username) || empty($email) || empty($password)){
    echo json_encode([
        "status" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

$check = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE email='$email'"
);

if(mysqli_num_rows($check) > 0){
    echo json_encode([
        "status"=>false,
        "message"=>"Email sudah digunakan"
    ]);
    exit;
}

$hashPassword = password_hash(
    $password,
    PASSWORD_BCRYPT
);

$query = mysqli_query(
    $conn,
    "INSERT INTO users(username,email,password)
    VALUES('$username','$email','$hashPassword')"
);

if($query){
    echo json_encode([
        "status"=>true,
        "message"=>"Register berhasil"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Register gagal"
    ]);
}
?>