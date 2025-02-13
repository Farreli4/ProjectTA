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
        $existingFile = $stmt->fetchColumn(); // Ambil nama file dari database

        // Jika mahasiswa belum pernah mengunggah file, tampilkan pop-up dan hentikan proses
        if (empty($existingFile)) {
            echo "<script>alert('Mahasiswa belum mengunggah file!'); window.history.back();</script>";
            exit();
        }

        // Ambil informasi file yang diunggah
        $file_name = $_FILES["lembar_persetujuan_laporan_ta_ujian"]["name"]; // Ambil nama asli
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

        // Buat folder uploads jika belum ada
        $upload_dir = "../../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Simpan file dengan nama unik (misalnya: id_mahasiswa_namaasli.pdf)
        $file_path = $upload_dir . $id_mahasiswa . "_" . $file_name;
        move_uploaded_file($file_tmp, $file_path);

        // Simpan path file ke database
        $sql = "UPDATE mahasiswa SET lembar_persetujuan_laporan_ta_ujian = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$file_path, $id_mahasiswa]);

        echo "<script>alert('File berhasil diunggah!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi!'); window.history.back();</script>";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
