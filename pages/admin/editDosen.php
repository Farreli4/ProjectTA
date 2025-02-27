<?php
include "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_dosen'];
    $nama = $_POST['nama_dosen'];
    $nip = $_POST['nip'];
    $prodi = $_POST['prodi'];
    $phone = $_POST['nomor_telepon'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    $sql = "UPDATE dosen_pembimbing SET 
            nama_dosen='$nama', 
            nip='$nip', 
            prodi='$prodi', 
            nomor_telepon='$phone', 
            username='$username', 
            pass='$pass' 
            WHERE id_dosen=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Data updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
