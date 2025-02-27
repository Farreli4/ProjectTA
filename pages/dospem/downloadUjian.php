<?php
require '../../config/connection.php';

if (isset($_GET['id'])) {
    $id_mahasiswa = $_GET['id'];

    try {
        $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ambil nama mahasiswa dan file dari database
        $stmt = $conn2->prepare("SELECT nama_mahasiswa, lembar_persetujuan_laporan_ta_ujian FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt->execute([$id_mahasiswa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['lembar_persetujuan_laporan_ta_ujian'])) {
            $nama_mahasiswa = $row['nama_mahasiswa'];
            $file_content = $row['lembar_persetujuan_laporan_ta_ujian']; // Ambil file BLOB

            // Bersihkan nama mahasiswa agar sesuai sebagai nama file
            $nama_mahasiswa_clean = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nama_mahasiswa);

            // Set header untuk mengunduh file
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"Lembar_Persetujuan_{$nama_mahasiswa_clean}_{$id_mahasiswa}.pdf\"");
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
