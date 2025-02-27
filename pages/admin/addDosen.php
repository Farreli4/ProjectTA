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
    if (isset($_POST['nama_dosen'], $_POST['nip'], $_POST['prodi'], $_POST['nomor_telepon'], $_POST['username'], $_POST['pass'])) {
        $nama = $_POST['nama_dosen'];
        $nip = $_POST['nip'];
        $prodi = $_POST['prodi'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];

        if (empty($nama) || empty($username) || empty($pass) || empty($nip) || empty($prodi) || empty($nomor_telepon)) {
            echo "All fields are required!";
            exit();
        }

        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);


        $stmt = $conn->prepare("INSERT INTO `dosen_pembimbing`(`nama_dosen`, `username`, `pass`, `nip`, `prodi`, `nomor_telepon`) VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssss", $nama, $username, $hashedPass, $nip, $prodi, $nomor_telepon);

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
