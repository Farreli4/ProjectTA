<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM dosen_pembimbing WHERE id_dosen = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo json_encode($row);
}

$conn->close();
?>
