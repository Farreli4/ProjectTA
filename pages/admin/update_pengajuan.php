<?php include '../../config/connection.php'; ?>
<?php
$conn->connect("127.0.0.1", "root", "", "sistem_ta");
if (isset($_POST['id_mahasiswa']) && isset($_POST['status_pengajuan'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_pengajuan = $_POST['status_pengajuan'];

    $valid_statuses = ['Ditolak','Disetujui', 'Revisi'];
    if (!in_array($status_pengajuan, $valid_statuses)) {
        echo "Invalid status value.";
        exit;
    }

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

        $stmt->close();;
}

$conn->close();
header("Location: pendaftaranta.php");
exit();

?>
