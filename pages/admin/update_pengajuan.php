<?php
$conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $status_pengajuan = $_POST["status_pengajuan"];

    $sql = "UPDATE tugas_akhir SET status_pengajuan=? WHERE id_mahasiswa=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status_pengajuan, $id_mahasiswa);
    
    if ($stmt->execute()) {
        echo "Status berhasil diperbarui!";
    } else {
        echo "Gagal memperbarui status.";
    }

    $stmt->close();
}
$conn->close();
?>
