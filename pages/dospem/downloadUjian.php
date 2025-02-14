<?php
require '../../config/connection.php';

if (isset($_GET['id'])) {
    $id_mahasiswa = $_GET['id'];

    try {
        $conn = new PDO("mysql:host=127.0.0.1;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ambil file dari database
        $stmt = $conn->prepare("SELECT lembar_persetujuan_laporan_ta_ujian FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt->execute([$id_mahasiswa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['lembar_persetujuan_laporan_ta_ujian'])) {
            $file_content = $row['lembar_persetujuan_laporan_ta_ujian']; // Ambil file BLOB

            // Set header untuk mengunduh file
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"file_mahasiswa_$id_mahasiswa.pdf\"");
            header("Content-Length: " . strlen($file_content));

            // Outputkan file
            echo $file_content;
            exit;
        } else {
            echo "<script>alert('Mahasiswa belum mengunggah file!'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
