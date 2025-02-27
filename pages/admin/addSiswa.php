<?php
include "../../config/connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama_mahasiswa'], $_POST['nim'], $_POST['prodi'], $_POST['kelas'], $_POST['nomor_telepon'], $_POST['username'], $_POST['pass'])) {
        $nama = $_POST['nama_mahasiswa'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $kelas = $_POST['kelas'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];

        if (empty($nama) || empty($username) || empty($pass) || empty($nim) || empty($prodi) || empty($kelas) || empty($nomor_telepon)) {
            echo "All fields are required!";
            exit();
        }

        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `mahasiswa`(`nama_mahasiswa`, `username`, `pass`, `nim`, `prodi`, `kelas`, `nomor_telepon`) VALUES (?, ?, ?, ?, ?, ?, ?)");
 
        $stmt->bind_param("sssssss", $nama, $username, $hashedPass, $nim, $prodi, $kelas, $nomor_telepon);

        if ($stmt->execute()) {
            echo "New record created successfully!";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Missing required fields!";
    }
}

$conn->close();
?>
