<?php include '../../config/connection.php'; ?>
<?php
var_dump($_POST['status_seminar']);
$conn->connect("127.0.0.1", "root", "", "sistem_ta");
if (isset($_POST['id_mahasiswa']) && isset($_POST['status_seminar'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status_seminar = $_POST['status_seminar'];

    $valid_statuses = ['Ditolak','Disetujui', 'Revisi'];
    if (!in_array($status_seminar, $valid_statuses)) {
        echo "Invalid status value.";
        exit;
    }

    $sql = "UPDATE seminar_proposal SET status_seminar = ? WHERE id_mahasiswa = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("si", $status_seminar, $id_mahasiswa);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing data.";
}

$conn->close();
header("Location: pendaftaranta.php");
exit();

?>
