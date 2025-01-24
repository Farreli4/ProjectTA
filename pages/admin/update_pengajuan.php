<?php
include '../../config/connection.php';


$conn->connect("127.0.0.1", "root", "", "sistem_ta");

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_pengajuan'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_pengajuan = $_POST['status_pengajuan'];

    $valid_statuses = ['Revisi', 'Ditolak', 'Disetujui'];
    if (!in_array($status_pengajuan, $valid_statuses)) {
        echo "Invalid status value.";
        exit;
    }

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

    $check_sql = "SELECT id_mahasiswa FROM tugas_akhir WHERE id_mahasiswa = ?";
    $check_stmt = $conn->prepare($check_sql);
    
    if ($check_stmt === false) {
        die("Error preparing check statement: " . $conn->error);
    }

    $check_stmt->bind_param("i", $id_mahasiswa);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $sql = "UPDATE tugas_akhir SET status_pengajuan = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("si", $status_pengajuan, $id_mahasiswa);

        if ($stmt->execute()) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $sql = "INSERT INTO tugas_akhir (id_mahasiswa, status_pengajuan) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("is", $id_mahasiswa, $status_pengajuan);

        if ($stmt->execute()) {
            echo "Status added successfully.";
        } else {
            echo "Error adding status: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $check_mahasiswa_stmt->close();
} else {
    echo "Error: Required fields are missing.";
}

$conn->close();

header("Location: pendaftaranta.php");
exit();
?>
