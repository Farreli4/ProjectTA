<?php
header("Content-Type: application/json");
session_start();
include "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data["username"];
    $password = $data["password"];

    // Query to match username and password for admin
    $query_admin = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $query_admin->execute(array($username, $password));
    $control_admin = $query_admin->fetch(PDO::FETCH_ASSOC);

    // Query to match username and password for dospem
    $query_dospem = $conn->prepare("SELECT * FROM dosen_pembimbing WHERE username=? AND password=?");
    $query_dospem->execute(array($username, $password));
    $control_dospem = $query_dospem->fetch(PDO::FETCH_ASSOC);

    // Query to match username and password for user
    $query_user = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $query_user->execute(array($username, $password));
    $control_user = $query_user->fetch(PDO::FETCH_ASSOC);

    if ($control_admin) {
        $_SESSION["username"] = $control_admin["username"];
        $_SESSION["role"] = 'admin';
        $redirectUrl = "../../pages/admin/index.php";
        echo json_encode([
            "status" => "success",
            "message" => "Login berhasil sebagai Admin",
            "role" => 'admin',
            "redirectUrl" => $redirectUrl
        ]);
    } elseif ($control_dospem) {
        $_SESSION["username"] = $control_dospem["username"];
        $_SESSION["role"] = 'dospem';
        $redirectUrl = "../../pages/dospem/index.php";
        echo json_encode([
            "status" => "success",
            "message" => "Login berhasil sebagai Dospem",
            "role" => 'dospem',
            "redirectUrl" => $redirectUrl
        ]);
    } elseif ($control_user) {
        $_SESSION["username"] = $control_user["username"];
        $_SESSION["role"] = 'user';
        $redirectUrl = "../../pages/user/index.php";
        echo json_encode([
            "status" => "success",
            "message" => "Login berhasil sebagai User",
            "role" => 'user',
            "redirectUrl" => $redirectUrl
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Username atau Password tidak sesuai"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
