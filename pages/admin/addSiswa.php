<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "sistem_ta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_mahasiswa'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];
    $kelas = $_POST['kelas'];
    $nomor_telepon = $_POST['nomor_telepon'];

    $sql = "INSERT INTO users (nama, email) VALUES ('$nama', '$username','$pass','$nim', '$prodi', '$kelas', '$nomor_telepon')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
