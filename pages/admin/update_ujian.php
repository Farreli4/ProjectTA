<?php
include '../../config/connection.php';
$conn->connect("127.0.0.1", "root", "", "sistem_ta");

if (!empty($_POST)) {
    echo "<script>";
    echo "console.log(" . json_encode($_POST) . ");";
    echo "</script>";
}

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_ujian']) && isset($_POST['nilai']) && isset($_POST['tanggal_ujian'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_ujian = $_POST['status_ujian'];
    $nilai = $_POST['nilai'];
    $tgl = $_POST['tanggal_ujian'];

    // Check if mahasiswa exists
    $check_mahasiswa_sql = "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?";
    $check_mahasiswa_stmt = $conn->prepare($check_mahasiswa_sql);
    if ($check_mahasiswa_stmt === false) {
        die("Error preparing check statement: " . $conn->error);
    }

    $check_mahasiswa_stmt->bind_param("i", $id_mahasiswa);
    $check_mahasiswa_stmt->execute();
    $check_mahasiswa_stmt->store_result();

    if ($check_mahasiswa_stmt->num_rows == 0) {
        echo "Error: id_mahasiswa does not exist in the mahasiswa table.";
        exit;
    }

    // Retrieve the dosen_pembimbing id from mahasiswa_dosen table
    $get_dosen_sql = "SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?";
    $stmt_get_dosen = $conn->prepare($get_dosen_sql);
    if ($stmt_get_dosen === false) {
        die("Error preparing get dosen query: " . $conn->error);
    }

    $stmt_get_dosen->bind_param("i", $id_mahasiswa);
    $stmt_get_dosen->execute();
    $stmt_get_dosen->bind_result($id_dosen);
    $stmt_get_dosen->fetch();
    $stmt_get_dosen->close();

    if (!$id_dosen) {
        echo "Error: Dosen pembimbing not found for the student.";
        exit;
    }

    // Validate status_ujian
    $valid_statuses = ['dijadwalkan', 'selesai'];
    if (!in_array($status_ujian, $valid_statuses)) {
        echo "Invalid status value.";
        exit;
    }

    if (!is_numeric($nilai)) {
        echo "Invalid nilai. It should be a number.";
        exit;
    }

    // Check if the mahasiswa has already an ujian entry
    $check_sql = "SELECT id_mahasiswa FROM ujian WHERE id_mahasiswa = ?";
    $check_stmt = $conn->prepare($check_sql);
    if ($check_stmt === false) {
        die("Error preparing check statement: " . $conn->error);
    }

    $check_stmt->bind_param("i", $id_mahasiswa);
    $check_stmt->execute();
    $check_stmt->store_result();

    // If the mahasiswa has an entry, update the existing record
    if ($check_stmt->num_rows > 0) {
        $sql = "UPDATE ujian SET status_ujian = ?, nilai = ?, tanggal_ujian = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing update statement: " . $conn->error);
        }

        $stmt->bind_param("siis", $status_ujian, $nilai, $tgl, $id_mahasiswa);

        if ($stmt->execute()) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $sql = "INSERT INTO ujian (id_mahasiswa, status_ujian, nilai, tanggal_ujian) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing insert statement: " . $conn->error);
        }

        $stmt->bind_param("isis", $id_mahasiswa, $status_ujian, $nilai, $tgl);

        if ($stmt->execute()) {
            echo "Status added successfully.";
        } else {
            echo "Error adding status: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_dosen = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
    $stmt_dosen->bind_param("i", $id_mahasiswa);
    $stmt_dosen->execute();
    $stmt_dosen->bind_result($nama_mahasiswa);
    $stmt_dosen->fetch();
    $stmt_dosen->close();

    $message = "Status ujian untuk siswa ". $nama_mahasiswa ."telah diupdate";

    $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status) VALUES (?, ?, ?, 'unread')";
    $stmt_notify = $conn->prepare($notification_sql);
    if (!$stmt_notify) {
        die("Error preparing notification query: " . $conn->error);
    }

    $stmt_notify->bind_param("iis", $id_dosen, $id_mahasiswa, $message);
    if (!$stmt_notify->execute()) {
        echo "Error inserting notification: " . $stmt_notify->error;
        $stmt_notify->close();
        exit;
    }

    $stmt_notify->close();

    $check_stmt->close();
    $check_mahasiswa_stmt->close();
} else {
    echo "Error: Required fields are missing.";
}

$conn->close();

header("Location: pendaftaranujian.php");
exit();
?>
