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
    if (isset($_POST['nama_mahasiswa'], $_POST['nim'], $_POST['prodi'], $_POST['kelas'], $_POST['nomor_telepon'], $_POST['pass'])) {
        $nama = $_POST['nama_mahasiswa'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $kelas = $_POST['kelas'];
        $nomor_telepon = $_POST['nomor_telepon'];
        $pass = $_POST['pass'];

        if (empty($nama) || empty($pass) || empty($nim) || empty($prodi) || empty($kelas) || empty($nomor_telepon)) {
            echo "All fields are required!";
            exit();
        }

        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `mahasiswa`(`nama_mahasiswa`, `pass`, `nim`, `prodi`, `kelas`, `nomor_telepon`) VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssss", $nama, $hashed_pass, $nim, $prodi, $kelas, $nomor_telepon);

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
