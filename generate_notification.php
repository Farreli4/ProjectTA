<?php
include "../../config/connection.php";
session_start();
$username = $_SESSION['username'];

$query = "SELECT 'dosen_pembimbing' AS source_table, id_dosen, username, pass, nip FROM dosen_pembimbing WHERE username = :username
          UNION 
          SELECT 'mahasiswa' AS source_table, id_mahasiswa, username, pass, nim FROM mahasiswa WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $username]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$error = '';

if ($row) {
    if ($row['source_table'] === 'dosen_pembimbing') {
        $user_id = $row['nip'];
        $message = "You have a new message!";
        
        $sql = "INSERT INTO notif (id_dosen, message) VALUES (:user_id, :message)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(['user_id' => $user_id, 'message' => $message])) {
            echo "Notification created successfully for Dosen!";
        } else {
            $error = "Failed to create notification for Dosen.";
        }
    } elseif ($row['source_table'] === 'mahasiswa') {
        $user_id = $row['nim'];
        $message = "You have a new message!";
        
        $sql = "INSERT INTO notif (id_mahasiswa, message) VALUES (:user_id, :message)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(['user_id' => $user_id, 'message' => $message])) {
            echo "Notification created successfully for Mahasiswa!";
        } else {
            $error = "Failed to create notification for Mahasiswa.";
        }
    } else {
        $error = "Invalid source table!";
    }

    if (empty($error)) {
        if (!headers_sent()) {
            header("Location: " . $redirectUrl);
            exit();
        } else {
            echo "Headers already sent. Using JavaScript redirect...";
            echo "<script>window.location.href = '$redirectUrl';</script>";
            exit();
        }
    } else {
        echo "<div class='alert alert-danger'>$error</div>";
    }
} else {
    echo "<div class='alert alert-danger'>$error</div>";
}
?>
