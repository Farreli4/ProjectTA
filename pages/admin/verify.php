<?php
require "../../config/connection.php";

$userId = $_POST['userId'];
$event = $_POST['event'];
$column = $_POST['column'];

// Use backticks around column name
$query = "UPDATE $event SET `$column` = 1 WHERE id_mahasiswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();

// Fetch the student's name
$stmt_nama = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
$stmt_nama->bind_param("i", $userId);
$stmt_nama->execute();
$stmt_nama->bind_result($nama_mahasiswa);
$stmt_nama->fetch();
$stmt_nama->close();

// Insert notification
$message = "File " . $column . " untuk mahasiswa " . $nama_mahasiswa . " telah diverifikasi.";
$notif_sql = "INSERT INTO notif (id_mahasiswa, message, status) VALUES (?, ?, 'unread')";
$stmt_notify = $conn->prepare($notif_sql);
$stmt_notify->bind_param("is", $userId, $message);

if (!$stmt_notify->execute()) {
    die("Error menambahkan notifikasi: " . $stmt_notify->error);
}

$stmt_notify->close();

echo "Success";

?>
