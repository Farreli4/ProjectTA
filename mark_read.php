<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=sistem_ta', 'root', '');

// ✅ Check if notification ID is provided in POST
if (!isset($_POST['id'])) {
    echo json_encode(['message' => 'Invalid request: No notification ID']);
    exit();
}

$notificationId = $_POST['id'];

if (!isset($_SESSION['username'])) {
    echo "<div class='alert alert-danger'>You are not logged in!</div>";
    exit();
}

$username = $_SESSION['username'];

try {
    $user_id = null;
    $user_type = null;

    $stmt = $pdo->prepare("SELECT id_dosen FROM dosen_pembimbing WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['id_dosen'];
        $user_type = 'dosen';
    } else {
        $stmt = $pdo->prepare("SELECT id_mahasiswa FROM mahasiswa WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row['id_mahasiswa'];
            $user_type = 'mahasiswa';
        } else {
            $stmt = $pdo->prepare("SELECT id_admin FROM admin WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $row['id_admin'];
                $user_type = 'admin';
            } else {
                echo json_encode(['message' => 'User not found']);
                exit();
            }
        }
    }

    if ($user_type === 'dosen') {
        $stmt = $pdo->prepare("UPDATE notif SET status_dosen = 'read' WHERE id = :notification_id AND id_dosen = :user_id AND status_dosen = 'unread'");
    } elseif ($user_type === 'mahasiswa') {
        $stmt = $pdo->prepare("UPDATE notif SET status_mahasiswa = 'read' WHERE id = :notification_id AND id_mahasiswa = :user_id AND status_mahasiswa = 'unread'");
    } elseif ($user_type === 'admin') {
        $stmt = $pdo->prepare("UPDATE notif SET status_admin = 'read' WHERE id = :notification_id AND admin = :user_id AND status_admin = 'unread'");
    }

    $stmt->execute(['notification_id' => $notificationId, 'user_id' => $user_id]);

    $stmt = $pdo->prepare("SELECT id_dosen, status_dosen, id_mahasiswa, status_mahasiswa, admin, status_admin FROM notif WHERE id = :notification_id");
    $stmt->execute(['notification_id' => $notificationId]);
    $notif = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$notif) {
        echo json_encode(['message' => 'Notification not found']);
        exit();
    }

    $allRead = true;
    if (!is_null($notif['id_dosen']) && $notif['status_dosen'] !== 'read') {
        $allRead = false;
    }
    if (!is_null($notif['id_mahasiswa']) && $notif['status_mahasiswa'] !== 'read') {
        $allRead = false;
    }
    if (!is_null($notif['admin']) && $notif['status_admin'] !== 'read') {
        $allRead = false;
    }

    if ($allRead) {
        $stmt = $pdo->prepare("DELETE FROM notif WHERE id = :notification_id");
        $stmt->execute(['notification_id' => $notificationId]);
    }

    echo json_encode(['message' => 'Checked notification status']);

    $previousPage = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    if (!headers_sent()) {
        header("Location: " . $previousPage);
        exit();
    } else {
        echo "<script>window.location.href = '$previousPage';</script>";
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
