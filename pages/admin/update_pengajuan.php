<?php
$conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_pengajuan']) && isset($_POST['dosen_pembimbing'])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $status_pengajuan = $_POST["status_pengajuan"];
    $dosen_pembimbing = $_POST["dosen_pembimbing"];
    $alasan_revisi = isset($_POST["alasan_revisi"]) ? $_POST["alasan_revisi"] : '';

    // Step 1: Check if the student exists in tugas_akhir table
    $check_sql = "SELECT COUNT(*) FROM tugas_akhir WHERE id_mahasiswa=?";
    $stmt_check = $conn->prepare($check_sql);
    if (!$stmt_check) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt_check->bind_param("i", $id_mahasiswa);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        // If the student exists, update the record in tugas_akhir table
        if ($status_pengajuan == 'Revisi' && !empty($alasan_revisi)) {
            // Update query for revisi
            $sql = "UPDATE tugas_akhir SET status_pengajuan=?, alasan_revisi=?, dosen_pembimbing=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing update query: " . $conn->error);
            }
            $stmt->bind_param("ssii", $status_pengajuan, $alasan_revisi, $dosen_pembimbing, $id_mahasiswa);
        } else {
            // Update query for other statuses (without alasan_revisi)
            $sql = "UPDATE tugas_akhir SET status_pengajuan=?, dosen_pembimbing=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing update query: " . $conn->error);
            }
            $stmt->bind_param("sii", $status_pengajuan, $dosen_pembimbing, $id_mahasiswa);
        }
    
    } else {
        // If the student does not exist in tugas_akhir, insert a new record into tugas_akhir
        if ($status_pengajuan == 'Revisi' && !empty($alasan_revisi)) {
            $sql = "INSERT INTO tugas_akhir (id_mahasiswa, status_pengajuan, alasan_revisi) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing insert query: " . $conn->error);
            }
            $stmt->bind_param("iss", $id_mahasiswa, $status_pengajuan, $alasan_revisi);
        } else {
            $sql = "INSERT INTO tugas_akhir (id_mahasiswa, status_pengajuan) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing insert query: " . $conn->error);
            }
            $stmt->bind_param("is", $id_mahasiswa, $status_pengajuan);
        }
    }

    // Execute the query for tugas_akhir table
    if (!$stmt->execute()) {
        // Output error message to debug
        echo "Gagal memperbarui status tugas_akhir. Error: " . $stmt->error;
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Step 2: Check if the dosen_pembimbing exists in dosen_pembimbing table
    $check_dosen_sql = "SELECT COUNT(*) FROM dosen_pembimbing WHERE id_dosen=?";
    $stmt_check_dosen = $conn->prepare($check_dosen_sql);
    if (!$stmt_check_dosen) {
        die("Error preparing dosen check query: " . $conn->error);
    }
    $stmt_check_dosen->bind_param("i", $dosen_pembimbing);
    $stmt_check_dosen->execute();
    $stmt_check_dosen->bind_result($dosen_exists);
    $stmt_check_dosen->fetch();
    $stmt_check_dosen->close();

    if ($dosen_exists > 0) {
        // Dosen exists, proceed to insert into mahasiswa_dosen table

        // Step 3: Check if the student and dosen_pembimbing are already linked in mahasiswa_dosen table
        $check_relation_sql = "SELECT COUNT(*) FROM mahasiswa_dosen WHERE id_mahasiswa=? AND id_dosen=?";
        $stmt_check_relation = $conn->prepare($check_relation_sql);
        if (!$stmt_check_relation) {
            die("Error preparing relation check query: " . $conn->error);
        }
        $stmt_check_relation->bind_param("ii", $id_mahasiswa, $dosen_pembimbing);
        $stmt_check_relation->execute();
        $stmt_check_relation->bind_result($relation_count);
        $stmt_check_relation->fetch();
        $stmt_check_relation->close();

        if ($relation_count == 0) {
            // If no existing relationship, insert it into mahasiswa_dosen table
            $insert_relation_sql = "INSERT INTO mahasiswa_dosen (id_mahasiswa, id_dosen) VALUES (?, ?)";
            $stmt_insert_relation = $conn->prepare($insert_relation_sql);
            if (!$stmt_insert_relation) {
                die("Error preparing insert relation query: " . $conn->error);
            }
            $stmt_insert_relation->bind_param("ii", $id_mahasiswa, $dosen_pembimbing);

            if (!$stmt_insert_relation->execute()) {
                echo "Gagal menambahkan dosen pembimbing. Error: " . $stmt_insert_relation->error;
                $stmt_insert_relation->close();
                exit;
            }

            $stmt_insert_relation->close();
        } else {
            echo "Dosen pembimbing sudah terhubung dengan mahasiswa ini.";
        }
    } else {
        echo "Dosen pembimbing dengan ID tersebut tidak ditemukan.";
    }

    // Success
    echo "Status dan dosen pembimbing berhasil diperbarui!";
    header("Location: pendaftaranTA.php");
    exit;

} else {
    echo "ID mahasiswa, status pengajuan, dan dosen pembimbing harus diisi!";
}

$conn->close();
?>
