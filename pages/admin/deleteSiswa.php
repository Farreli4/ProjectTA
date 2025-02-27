<?php
include "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_mahasiswa'];
    $sql = "DELETE FROM mahasiswa WHERE id_mahasiswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
