<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

$id = $_POST['id_mahasiswa'];
$nama = $_POST['nama_mahasiswa'];
$nim = $_POST['nim'];
$prodi = $_POST['prodi'];
$kelas = $_POST['kelas'];
$telepon = $_POST['nomor_telepon'];
$username = $_POST['username'];

$sql = "UPDATE mahasiswa SET nama_mahasiswa='$nama', nim='$nim', prodi='$prodi', kelas='$kelas', nomor_telepon='$telepon', username='$username' WHERE id_mahasiswa='$id'";

if ($conn->query($sql) === TRUE) {
  echo "Success";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
