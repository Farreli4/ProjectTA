<?php
require '../../config/connection.php'; // Koneksi ke database

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=sistem_ta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["lembar_persetujuan_laporan_ta_ujian"])) {
        $id_mahasiswa = $_POST['id_mahasiswa'];

        // Cek apakah mahasiswa sudah memiliki file sebelumnya
        $stmt = $conn->prepare("SELECT lembar_persetujuan_laporan_ta_ujian FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt->execute([$id_mahasiswa]);
        $existingFile = $stmt->fetchColumn(); // Ambil file dari database

        // Jika mahasiswa belum pernah mengunggah file, tampilkan pop-up dan hentikan proses
        if (empty($existingFile)) {
            echo "<script>alert('Mahasiswa belum mengunggah file!'); window.history.back();</script>";
            exit();
        }

        // Ambil informasi file yang diunggah
        $file_tmp = $_FILES["lembar_persetujuan_laporan_ta_ujian"]["tmp_name"];
        $file_size = $_FILES["lembar_persetujuan_laporan_ta_ujian"]["size"];
        $file_type = $_FILES["lembar_persetujuan_laporan_ta_ujian"]["type"];

        // Validasi tipe file harus PDF
        if ($file_type !== "application/pdf") {
            echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
            exit();
        }

        // Validasi ukuran file maksimal 5MB
        if ($file_size > 5 * 1024 * 1024) { // 5MB
            echo "<script>alert('File terlalu besar! Maksimal 5MB'); window.history.back();</script>";
            exit();
        }

        // Baca file sebagai BLOB
        $file_content = file_get_contents($file_tmp);

        // Simpan file ke database
        $sql = "UPDATE mahasiswa SET lembar_persetujuan_laporan_ta_ujian = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$file_content, $id_mahasiswa]);

        $stmt_dosen = $conn->prepare("SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?");
        $stmt_dosen->execute([$id_mahasiswa]);
        $id_dosen = $stmt_dosen->fetchColumn();

        $stmt_dosen = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt_dosen->execute([$id_mahasiswa]);
        $nama_mahasiswa = $stmt_dosen->fetchColumn();

        if (!$id_dosen) {
            echo "<script>alert('Dosen pembimbing tidak ditemukan!'); window.history.back();</script>";
            exit();
        }

        $message = "File Laporan TA Ujian telah di upload oleh siswa " . $nama_mahasiswa . ".";

        $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status) VALUES (?, ?, ?, 'unread')";
        $stmt_notify = $conn->prepare($notification_sql);
        $stmt_notify->execute([$id_dosen, $id_mahasiswa, $message]);

        echo "<script>alert('File berhasil diunggah!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi!'); window.history.back();</script>";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
