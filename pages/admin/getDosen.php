<?php
include "../../config/connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM dosen_pembimbing WHERE id_dosen = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo json_encode($row);
}

$conn->close();
?>
