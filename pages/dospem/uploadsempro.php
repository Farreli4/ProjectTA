<?php
require '../../config/connection.php'; // Koneksi ke database

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=sistem_ta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["lembar_persetujuan_proposal_ta_seminar"])) {
        $id_mahasiswa = $_POST['id_mahasiswa'];

        // Cek apakah mahasiswa sudah memiliki file sebelumnya
        $stmt = $conn->prepare("SELECT lembar_persetujuan_proposal_ta_seminar FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt->execute([$id_mahasiswa]);
        $existingFile = $stmt->fetchColumn(); // Ambil file dari database

        // Jika mahasiswa belum pernah mengunggah file, tampilkan pop-up dan hentikan proses
        if (empty($existingFile)) {
            echo "<script>alert('Mahasiswa belum mengunggah file!'); window.history.back();</script>";
            exit();
        }

        // Ambil informasi file yang diunggah
        $file_tmp = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["tmp_name"];
        $file_size = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["size"];
        $file_type = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["type"];
        $file_content = file_get_contents($file_tmp); // Baca isi file

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

        // Simpan file langsung ke database dalam bentuk BLOB
        $sql = "UPDATE mahasiswa SET lembar_persetujuan_proposal_ta_seminar = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$file_content, $id_mahasiswa]);

        // Retrieve the id_dosen from mahasiswa_dosen table
        $stmt_dosen = $conn->prepare("SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?");
        $stmt_dosen->execute([$id_mahasiswa]);
        $id_dosen = $stmt_dosen->fetchColumn();

        // If no dosen found, show an error
        if (!$id_dosen) {
            echo "<script>alert('Dosen pembimbing tidak ditemukan!'); window.history.back();</script>";
            exit();
        }

        $stmt_dosen = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt_dosen->execute([$id_mahasiswa]);
        $nama_mahasiswa = $stmt_dosen->fetchColumn();

        // Prepare notification message
        $message = "File Seminar Proposal telah di upload oleh siswa " . $nama_mahasiswa . ".";

        // Insert notification for dosen
        $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status) VALUES (?, ?, ?, 'unread')";
        $stmt_notify = $conn->prepare($notification_sql);
        $stmt_notify->execute([$id_dosen, $id_mahasiswa, $message]);

        echo "<script>alert('File berhasil diunggah!'); window.location.href='../../pages/dospem/dokumenSempro.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi!'); window.history.back();</script>";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
