<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=sistem_ta', 'root', '');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        
        $queryDosen = "SELECT 'dosen_pembimbing' AS source_table, id_dosen, username, pass, nip FROM dosen_pembimbing WHERE username = :username";
        $stmt = $pdo->prepare($queryDosen);
        $stmt->execute(['username' => $username]);

        $rowDosen = $stmt->fetch(PDO::FETCH_ASSOC);

        // If it's a dosen_pembimbing, fetch notifications for that user
        if ($rowDosen) {
            $user_id = $rowDosen['id_dosen'];
            $sql = "SELECT id, message, created_at FROM notif WHERE id_dosen = :user_id AND status_dosen = 'unread'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($notifications)) {
                echo json_encode(['message' => 'No unread notifications for dosen_pembimbing']);
            } else {
                echo json_encode($notifications);
            }
        } else {
            // If not found in dosen_pembimbing, check mahasiswa
            $queryMahasiswa = "SELECT 'mahasiswa' AS source_table, id_mahasiswa, username, pass, nim FROM mahasiswa WHERE username = :username";
            $stmt = $pdo->prepare($queryMahasiswa);
            $stmt->execute(['username' => $username]);

            $rowMahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rowMahasiswa) {
                $user_id = $rowMahasiswa['id_mahasiswa'];
                $sql = "SELECT id, message, created_at FROM notif WHERE id_mahasiswa = :user_id AND status_mahasiswa = 'unread'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user_id' => $user_id]);
                $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($notifications)) {
                    echo json_encode(['message' => 'No unread notifications for dosen_pembimbing']);
                } else {
                    echo json_encode($notifications);
                }
            } else {
                echo json_encode(['message' => 'User not found']);
            }
        }

    } catch (PDOException $e) {
        // Error handling if query fails
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If session doesn't exist
    echo json_encode(['message' => 'User not logged in']);
}
?>
