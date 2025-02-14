<?php
include '../../config/connection.php';

// Pastikan koneksi ke database berhasil
$conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!empty($_POST)) {
    echo "<script>console.log(" . json_encode($_POST) . ");</script>";
}

if (isset($_POST['id_mahasiswa'], $_POST['status_ujian'], $_POST['nilai'], $_POST['tanggal_ujian'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_ujian = $_POST['status_ujian'];
    $nilai = $_POST['nilai'];
    $tgl = $_POST['tanggal_ujian'];

    // Validasi status_ujian
    $valid_statuses = ['dijadwalkan', 'selesai'];
    if (!in_array($status_ujian, $valid_statuses)) {
        die("Invalid status value.");
    }

    // Validasi id_mahasiswa
    if (empty($id_mahasiswa) || !is_numeric($id_mahasiswa)) {
        die("Error: id_mahasiswa is invalid.");
    }

    // Validasi nilai
    if (!is_numeric($nilai)) {
        die("Invalid nilai. It should be a number.");
    }

    // Cek apakah mahasiswa ada di database
    $check_mahasiswa_sql = "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?";
    $check_mahasiswa_stmt = $conn->prepare($check_mahasiswa_sql);
    $check_mahasiswa_stmt->bind_param("i", $id_mahasiswa);
    $check_mahasiswa_stmt->execute();
    $check_mahasiswa_stmt->store_result();

    if ($check_mahasiswa_stmt->num_rows == 0) {
        die("Error: id_mahasiswa does not exist.");
    }

    // Cek apakah data ujian sudah ada
    $check_sql = "SELECT id_mahasiswa FROM ujian WHERE id_mahasiswa = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id_mahasiswa);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Jika data sudah ada, lakukan update
        $sql = "UPDATE ujian SET status_ujian = ?, nilai = ?, tanggal_ujian = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $status_ujian, $nilai, $tgl, $id_mahasiswa);
    } else {
        // Jika belum ada, lakukan insert
        $sql = "INSERT INTO ujian (id_mahasiswa, status_ujian, nilai, tanggal_ujian) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $id_mahasiswa, $status_ujian, $nilai, $tgl);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        die("Error: " . $stmt->error);
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $check_stmt->close();
    $check_mahasiswa_stmt->close();
    $conn->close();

    // Redirect setelah sukses
    header("Location: pendaftaranujian.php");
    exit();
} else {
    die("Error: Required fields are missing.");
}
?>
