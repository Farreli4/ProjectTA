<?php
$conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_pengajuan'])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $status_pengajuan = $_POST["status_pengajuan"];
    $alasan_revisi = isset($_POST["alasan_revisi"]) ? $_POST["alasan_revisi"] : '';

    $check_sql = "SELECT COUNT(*) FROM tugas_akhir WHERE id_mahasiswa=?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $id_mahasiswa);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        // If the student exists, update the record
        if ($status_pengajuan == 'Revisi' && !empty($alasan_revisi)) {
            $sql = "UPDATE tugas_akhir SET status_pengajuan=?, alasan_revisi=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $status_pengajuan, $alasan_revisi, $id_mahasiswa);
        } else {
            $sql = "UPDATE tugas_akhir SET status_pengajuan=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $status_pengajuan, $id_mahasiswa);
        }
    } else {
        // If the student does not exist, insert a new record
        if ($status_pengajuan == 'Revisi' && !empty($alasan_revisi)) {
            $sql = "INSERT INTO tugas_akhir (id_mahasiswa, status_pengajuan, alasan_revisi) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $id_mahasiswa, $status_pengajuan, $alasan_revisi);
        } else {
            $sql = "INSERT INTO tugas_akhir (id_mahasiswa, status_pengajuan) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $id_mahasiswa, $status_pengajuan);
        }
    }

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "Status berhasil diperbarui!";
        header("Location: pendaftaranTA.php");
        exit;
    } else {
        echo "Gagal memperbarui status.";
    }

    $stmt->close();
} else {
    echo "ID mahasiswa dan status pengajuan harus diisi!";
}

$conn->close();
?>
