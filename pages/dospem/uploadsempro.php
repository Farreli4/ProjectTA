<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
require '../../config/connection.php';

try {
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["lembar_persetujuan_proposal_ta_seminar"])) {
        $id_mahasiswa = $_POST['id_mahasiswa'];

        // Cek file sebelumnya
        $stmt = $conn2->prepare("SELECT lembar_persetujuan_proposal_ta_seminar FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt->execute([$id_mahasiswa]);
        $existingFile = $stmt->fetchColumn();

        if (empty($existingFile)) {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'File Belum Diupload',
                    text: 'Mahasiswa belum mengunggah file!',
                    confirmButtonText: 'Kembali'
                }).then((result) => {
                    window.history.back();
                });
                </script>";
                exit();
            
        }

        // Proses file
        $file_tmp = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["tmp_name"];
        $file_size = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["size"];
        $file_type = $_FILES["lembar_persetujuan_proposal_ta_seminar"]["type"];
        $file_content = file_get_contents($file_tmp);

        // Validasi tipe file
        if ($file_type !== "application/pdf") {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Tipe File Tidak Valid',
                    text: 'Hanya file PDF yang diperbolehkan!',
                    confirmButtonText: 'Kembali'
                }).then((result) => {
                    window.history.back();
                });
                </script>";
            exit();
        }

        // Validasi ukuran
        if ($file_size > 5 * 1024 * 1024) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'File terlalu besar! Maksimal 5MB',
                    confirmButtonText: 'Kembali'
                }).then((result) => {
                    window.history.back();
                });
                </script>";
            exit();
        }

        // Update database
        $sql = "UPDATE mahasiswa SET lembar_persetujuan_proposal_ta_seminar = ? WHERE id_mahasiswa = ?";
        $stmt = $conn2->prepare($sql);
        $stmt->execute([$file_content, $id_mahasiswa]);

        // Get dosen ID
        $stmt_dosen = $conn2->prepare("SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?");
        $stmt_dosen->execute([$id_mahasiswa]);
        $id_dosen = $stmt_dosen->fetchColumn();

        if (!$id_dosen) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Dosen Tidak Ditemukan',
                    text: 'Dosen pembimbing tidak ditemukan!',
                    confirmButtonText: 'Kembali'
                }).then((result) => {
                    window.history.back();
                });
                </script>";
            exit();
        }

        // Get nama mahasiswa
        $stmt_nama = $conn2->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
        $stmt_nama->execute([$id_mahasiswa]);
        $nama_mahasiswa = $stmt_nama->fetchColumn();

        // Create notification
        $message = "File Seminar Proposal telah di upload oleh siswa " . $nama_mahasiswa . ".";
        $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status) VALUES (?, ?, ?, 'unread')";
        $stmt_notify = $conn2->prepare($notification_sql);
        $stmt_notify->execute([$id_dosen, $id_mahasiswa, $message]);

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'File berhasil diunggah!',
                confirmButtonText: 'Lanjut'
            }).then((result) => {
                window.location.href = '../../pages/dospem/dokumenSempro.php';
            });
            </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Terjadi kesalahan, silakan coba lagi!',
                confirmButtonText: 'Kembali'
            }).then((result) => {
                window.history.back();
            });
            </script>";
    }
} catch (PDOException $e) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Database Error',
            text: 'Terjadi kesalahan database: " . $e->getMessage() . "',
            confirmButtonText: 'Kembali'
        }).then((result) => {
            window.history.back();
        });
        </script>";
}
?>
</body>
</html>
<?php
ob_end_flush();
?>