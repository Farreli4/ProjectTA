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

        $salt = bin2hex(random_bytes(54));

        $salted = $salt . $pass;

        $hashed_pass = hash("sha256", $salted);

        $stmt = $conn->prepare("INSERT INTO `mahasiswa`(`nama_mahasiswa`, `username`, `pass`, `nim`, `prodi`, `kelas`, `nomor_telepon`, `salt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
 
        $stmt->bind_param("ssssssssi", $nama, $username, $hashed_pass, $nim, $prodi, $kelas, $nomor_telepon, $salt);

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
