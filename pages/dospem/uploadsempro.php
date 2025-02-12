<?php
require '../../config/connection.php'; // Pastikan ada koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["sppsp"])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $target_dir = "uploads/"; // Folder penyimpanan file
    $file_name = "sppsp_" . $id_mahasiswa . "_" . time() . ".pdf";
    $target_file = $target_dir . $file_name;

    // Pastikan folder uploads ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Ambil file lama jika ada (Menggunakan MySQLi)
    $stmt = $conn->prepare("SELECT sppsp FROM seminar_proposal WHERE id_mahasiswa = ?");
    $stmt->bind_param("i", $id_mahasiswa);
    $stmt->execute();
    $stmt->bind_result($old_file_name);
    $stmt->fetch(); // ✅ MySQLi fetch() tidak boleh ada argumen
    $stmt->close();

    if (!empty($old_file_name)) {
        $old_file = $target_dir . $old_file_name;
        if (file_exists($old_file)) {
            unlink($old_file); // Hapus file lama
        }
    }

    // Upload file baru
    if (move_uploaded_file($_FILES["sppsp"]["tmp_name"], $target_file)) {
        // Simpan nama file ke database
        $stmt = $conn->prepare("UPDATE seminar_proposal SET sppsp = ? WHERE id_mahasiswa = ?");
        $stmt->bind_param("si", $file_name, $id_mahasiswa);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('File berhasil diunggah!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah file!'); window.history.back();</script>";
    }
}
?>
