<?php
session_start();
include "../../config/connection.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Check if user is a dosen_pembimbing
        $queryDosen = "SELECT 'dosen_pembimbing' AS source_table, id_dosen AS user_id FROM dosen_pembimbing WHERE username = :username";
        $stmt = $pdo->prepare($queryDosen);
        $stmt->execute(['username' => $username]);
        $rowDosen = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowDosen) {
            $user_id = $rowDosen['user_id'];
            $sql = "SELECT id, message, created_at FROM notif WHERE id_dosen = :user_id AND status_dosen = 'unread'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $queryMahasiswa = "SELECT 'mahasiswa' AS source_table, id_mahasiswa AS user_id FROM mahasiswa WHERE username = :username";
            $stmt = $pdo->prepare($queryMahasiswa);
            $stmt->execute(['username' => $username]);
            $rowMahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rowMahasiswa) {
                $user_id = $rowMahasiswa['user_id'];
                $sql = "SELECT id, message, created_at FROM notif WHERE id_mahasiswa = :user_id AND status_mahasiswa = 'unread'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user_id' => $user_id]);
                $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $queryAdmin = "SELECT 'admin' AS source_table, id_admin AS user_id FROM admin WHERE username = :username";
                $stmt = $pdo->prepare($queryAdmin);
                $stmt->execute(['username' => $username]);
                $rowAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rowAdmin) {
                    $user_id = $rowAdmin['user_id'];
                    $sql = "SELECT id, message, created_at FROM notif WHERE admin = :user_id AND status_admin = 'unread'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['user_id' => $user_id]);
                    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    echo json_encode(['message' => 'User not found']);
                    exit;
                }
            }
        }

        // ✅ Return notifications
        if (empty($notifications)) {
            echo json_encode(['message' => 'No unread notifications']);
        } else {
            echo json_encode($notifications);
        }

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If session doesn't exist
    echo json_encode(['message' => 'User not logged in']);
}
?>
