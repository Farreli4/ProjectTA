<?php
include "../../config/connection.php";

if (isset($_POST['id_mahasiswa']) && isset($_POST['status_pengajuan']) && isset($_POST['dosen_pembimbing'])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $status_pengajuan = $_POST["status_pengajuan"];
    $dosen_pembimbing = $_POST["dosen_pembimbing"];
    $alasan_revisi = isset($_POST["alasan_revisi"]) ? $_POST["alasan_revisi"] : '';

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
        // Update the status_pengajuan and dosen_pembimbing if needed
        if ($status_pengajuan == 'Revisi' && !empty($alasan_revisi)) {
            $sql = "UPDATE tugas_akhir SET status_pengajuan=?, alasan_revisi=?, dosen_pembimbing=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing update query: " . $conn->error);
            }
            $stmt->bind_param("ssii", $status_pengajuan, $alasan_revisi, $dosen_pembimbing, $id_mahasiswa);
        } else {
            $sql = "UPDATE tugas_akhir SET status_pengajuan=?, dosen_pembimbing=? WHERE id_mahasiswa=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing update query: " . $conn->error);
            }
            $stmt->bind_param("sii", $status_pengajuan, $dosen_pembimbing, $id_mahasiswa);
        }
    } else {
        // Insert a new record if the mahasiswa doesn't have a status_pengajuan
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

    if (!$stmt->execute()) {
        echo "Gagal memperbarui status tugas_akhir. Error: " . $stmt->error;
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Check if the dosen exists
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
        $check_relation_sql = "SELECT id_dosen FROM mahasiswa_dosen WHERE id_mahasiswa=?";
        $stmt_check_relation = $conn->prepare($check_relation_sql);
        if (!$stmt_check_relation) {
            die("Error preparing relation check query: " . $conn->error);
        }
        $stmt_check_relation->bind_param("i", $id_mahasiswa);
        $stmt_check_relation->execute();
        $stmt_check_relation->bind_result($current_dosen);
        $stmt_check_relation->fetch();
        $stmt_check_relation->close();

        if ($current_dosen) {
            if ($current_dosen != $dosen_pembimbing) {
                $update_relation_sql = "UPDATE mahasiswa_dosen SET id_dosen=? WHERE id_mahasiswa=?";
                $stmt_update_relation = $conn->prepare($update_relation_sql);
                if (!$stmt_update_relation) {
                    die("Error preparing update relation query: " . $conn->error);
                }
                $stmt_update_relation->bind_param("ii", $dosen_pembimbing, $id_mahasiswa);
                
                if (!$stmt_update_relation->execute()) {
                    echo "Gagal memperbarui dosen pembimbing. Error: " . $stmt_update_relation->error;
                    $stmt_update_relation->close();
                    exit;
                }
                
                $stmt_update_relation->close();
                echo "Dosen pembimbing berhasil diperbarui.";
            } else {
                echo "Dosen pembimbing sudah terhubung dengan mahasiswa ini.";
            }
        } else {
            // If the student doesn't have a dosen yet, insert a new relation
            $insert_relation_sql = "INSERT INTO mahasiswa_dosen (id_mahasiswa, id_dosen) VALUES (?, ?)";
            $stmt_insert_relation = $conn->prepare($insert_relation_sql);
            if (!$stmt_insert_relation) {
                die("Error preparing insert relation query: " . $conn->error);
            }
            $stmt_insert_relation->bind_param("ii", $id_mahasiswa, $dosen_pembimbing);
        
            if (!$stmt_insert_relation->execute()) {
                echo "Gagal menambahkan hubungan dosen dan mahasiswa. Error: " . $stmt_insert_relation->error;
                $stmt_insert_relation->close();
                exit;
            }
        
            $stmt_insert_relation->close();
            echo "Dosen pembimbing berhasil ditambahkan untuk mahasiswa ini.";
        }
    }

    $stmt_dosen = $conn->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");
    $stmt_dosen->bind_param("i", $id_mahasiswa);
    $stmt_dosen->execute();
    $stmt_dosen->bind_result($nama_mahasiswa);
    $stmt_dosen->fetch();
    $stmt_dosen->close();

    $message = "Pengajuan tugas ". $nama_mahasiswa ." telah '$status_pengajuan'";
    if ($status_pengajuan == 'Revisi') {
        $message = "Pengajuan tugas akhir milik ". $nama_mahasiswa . " dikembalikan lagi karena $alasan_revisi";
    }

    $notification_sql = "INSERT INTO notif (id_dosen, id_mahasiswa, message, status_dosen, status_admin) VALUES (?, ?, ?, 'unread', 'unread')";
    $stmt_notify = $conn->prepare($notification_sql);
    if (!$stmt_notify) {
        die("Error preparing notification query: " . $conn->error);
    }
    $stmt_notify->bind_param("iis", $dosen_pembimbing, $id_mahasiswa, $message);
    if (!$stmt_notify->execute()) {
        echo "Error inserting notification: " . $stmt_notify->error;
        $stmt_notify->close();
        exit;
    }

    $stmt_notify->close();

    echo "Status dan dosen pembimbing berhasil diperbarui dan notifikasi dikirim!";
    header("Location: pendaftaranTA.php");
    exit;

} else {
    echo "ID mahasiswa, status pengajuan, dan dosen pembimbing harus diisi!";
}

$conn->close();

?>
