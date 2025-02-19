<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_dosen'];
    $sql = "DELETE FROM dosen_pembimbing WHERE id_dosen = ?";
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
