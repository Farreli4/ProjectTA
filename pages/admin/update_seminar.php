<?php
include '../../config/connection.php';

$conn->connect("127.0.0.1", "root", "", "sistem_ta");

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_seminar'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_seminar = $_POST['status_seminar'];
    $tanggal_seminar = $_POST['tanggal_seminar'];

    $valid_statuses = ['dijadwalkan', 'ditunda', 'selesai'];
    if (!in_array($status_seminar, $valid_statuses)) {
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

    $check_sql = "SELECT id_mahasiswa FROM seminar_proposal WHERE id_mahasiswa = ?";
    $check_stmt = $conn->prepare($check_sql);
    
    if ($check_stmt === false) {
        die("Error preparing check statement: " . $conn->error);
    }

    $check_stmt->bind_param("i", $id_mahasiswa);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $sql = "UPDATE seminar_proposal SET status_seminar = ?, tanggal_seminar = ? WHERE id_mahasiswa = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssi", $status_seminar, $tanggal_seminar, $id_mahasiswa);

        if ($stmt->execute()) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $sql = "INSERT INTO seminar_proposal (id_mahasiswa, status_seminar, tanggal_seminar) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("iss", $id_mahasiswa, $status_seminar, $tanggal_seminar); 

        if ($stmt->execute()) {
            echo "Status added successfully.";
        } else {
            echo "Error adding status: " . $stmt->error;
        }

        $stmt->close();
    }

    $get_dosen_sql = "SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa = ?";
    $stmt_dosen = $conn->prepare($get_dosen_sql);
    $stmt_dosen->bind_param("i", $id_mahasiswa);
    $stmt_dosen->execute();
    $stmt_dosen->bind_result($id_dosen);
    $stmt_dosen->fetch();
    $stmt_dosen->close();

    if ($id_dosen) {
        $message = "The seminar status has been updated to '" . $status_seminar . "'.";

        $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status) VALUES (?, ?, ?, 'unread')";
        $stmt_notify = $conn->prepare($notification_sql);
        $stmt_notify->bind_param("iis", $id_dosen, $id_mahasiswa, $message);
        
        if (!$stmt_notify->execute()) {
            echo "Error inserting notification: " . $stmt_notify->error;
            $stmt_notify->close();
            exit;
        }

        $stmt_notify->close();
    } else {
        echo "Error: Dosen pembimbing not found for the student.";
    }

    $check_stmt->close();
    $check_mahasiswa_stmt->close();
} else {
    echo "Error: Required fields are missing.";
}

$conn->close();

header("Location: pendaftaranseminar.php");
exit();
?>
