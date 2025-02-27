<?php
$conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_mahasiswa = $_POST['id_mahasiswa'];
$nilai1 = $_POST['nilai1'];
$nilai2 = $_POST['nilai2'];
$rata_rata = ($nilai1 + $nilai2) / 2;

$sql = "UPDATE ujian SET nilai = '$rata_rata' WHERE id_mahasiswa = '$id_mahasiswa'";

if ($conn->query($sql) === TRUE) {
    echo "Nilai berhasil disimpan";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
