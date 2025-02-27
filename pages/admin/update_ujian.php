<?php
include '../../config/connection.php';

// Debugging: Melihat data yang dikirim dari form
if (!empty($_POST)) {
    echo "<script>console.log(" . json_encode($_POST) . ");</script>";
}

// Pastikan semua field yang diperlukan tersedia
if (isset($_POST['id_mahasiswa'], $_POST['status_ujian'], $_POST['nilai'], $_POST['tanggal_ujian'])) {
    $id_mahasiswa = (int) $_POST['id_mahasiswa'];
    $status_ujian = trim($_POST['status_ujian']);
    $nilai = (float) $_POST['nilai'];
    $tgl = $_POST['tanggal_ujian'];

    // Validasi status ujian
    $valid_statuses = ['dijadwalkan', 'selesai', 'ditunda'];
    if (!in_array($status_ujian, $valid_statuses)) {
        die("Error: Status ujian tidak valid.");
    }

    // Validasi ID mahasiswa
    if (empty($id_mahasiswa) || !is_numeric($id_mahasiswa)) {
        die("Error: ID mahasiswa tidak valid.");
    }

    // Validasi nilai
    if (!is_numeric($nilai)) {
        die("Error: Nilai harus berupa angka.");
    }

    // Validasi tanggal
    $tgl = date('Y-m-d', strtotime($tgl));
    if (!$tgl) {
        die("Error: Format tanggal tidak valid.");
    }

    // Cek apakah mahasiswa ada di database
    $check_mahasiswa_sql = "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?";
    $stmt_mahasiswa = $conn->prepare($check_mahasiswa_sql);
    $stmt_mahasiswa->bind_param("i", $id_mahasiswa);
    $stmt_mahasiswa->execute();
    $stmt_mahasiswa->store_result();

    if ($stmt_mahasiswa->num_rows == 0) {
        die("Error: Mahasiswa tidak ditemukan.");
    }
    $stmt_mahasiswa->close();

    // Ambil id_dosen berdasarkan id_mahasiswa
    $get_dosen_sql = "SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?";
    $stmt_get_dosen = $conn->prepare($get_dosen_sql);
    $stmt_get_dosen->bind_param("i", $id_mahasiswa);
    $stmt_get_dosen->execute();
    $stmt_get_dosen->bind_result($id_dosen);
    $stmt_get_dosen->fetch();
    $stmt_get_dosen->close();

    if (!$id_dosen) {
        die("Error: Dosen pembimbing tidak ditemukan.");
    }

    // Cek apakah mahasiswa sudah memiliki entri ujian
    $check_sql = "SELECT id_mahasiswa FROM ujian WHERE id_mahasiswa = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id_mahasiswa);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE ujian SET status_ujian = ?, nilai = ?, tanggal_ujian = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsi", $status_ujian, $nilai, $tgl, $id_mahasiswa);
    } else {
        // Jika belum ada, lakukan insert
        $sql = "INSERT INTO ujian (id_mahasiswa, status_ujian, nilai, tanggal_ujian) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isds", $id_mahasiswa, $status_ujian, $nilai, $tgl);
    }
    $check_stmt->close();

    if ($stmt->execute()) {
        echo "Status ujian berhasil diperbarui.";
    } else {
        die("Error dalam menyimpan data: " . $stmt->error);
    }
    $stmt->close();

    // Ambil nama mahasiswa
    $stmt_nama = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
    $stmt_nama->bind_param("i", $id_mahasiswa);
    $stmt_nama->execute();
    $stmt_nama->bind_result($nama_mahasiswa);
    $stmt_nama->fetch();
    $stmt_nama->close();

    // Tambahkan notifikasi ke dosen
    $message = "Status ujian untuk mahasiswa " . $nama_mahasiswa . " telah diperbarui.";
    $notif_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status_dosen, status_mahasiswa) VALUES (?, ?, ?, 'unread', 'unread')";
    $stmt_notify = $conn->prepare($notif_sql);
    $stmt_notify->bind_param("iis", $id_dosen, $id_mahasiswa, $message);

    if (!$stmt_notify->execute()) {
        die("Error menambahkan notifikasi: " . $stmt_notify->error);
    }

    $stmt_notify->close();
    $conn->close();

    // Redirect setelah sukses
    header("Location: pendaftaranujian.php");
    exit();
} else {
    die("Error: Data yang diperlukan tidak lengkap.");
}
