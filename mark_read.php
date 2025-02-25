<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=sistem_ta', 'root', '');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Check if the user is a 'dosen_pembimbing'
        $queryDosen = "SELECT 'dosen_pembimbing' AS source_table, id_dosen, username, pass, nip FROM dosen_pembimbing WHERE username = :username";
        $stmt = $pdo->prepare($queryDosen);
        $stmt->execute(['username' => $username]);

        $rowDosen = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the user is found in 'dosen_pembimbing', mark notifications as read
        if ($rowDosen) {
            $user_id = $rowDosen['id_dosen'];  // Using id_dosen for 'dosen_pembimbing'
            $sql = "UPDATE notif SET status_dosen = 'read' WHERE id_dosen = :user_id AND status_dosen = 'unread'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);

            // Set the message and redirection URL for dosen_pembimbing
            $message = "Notifications for Dosen Pembimbing marked as read!";
        } else {
            // If not found in 'dosen_pembimbing', check for 'mahasiswa'
            $queryMahasiswa = "SELECT 'mahasiswa' AS source_table, id_mahasiswa, username, pass, nim FROM mahasiswa WHERE username = :username";
            $stmt = $pdo->prepare($queryMahasiswa);
            $stmt->execute(['username' => $username]);

            $rowMahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

            // If the user is found in 'mahasiswa', mark notifications as read
            if ($rowMahasiswa) {
                $user_id = $rowMahasiswa['id_mahasiswa'];  // Using id_mahasiswa for 'mahasiswa'
                $sql = "UPDATE notif SET status_mahasiswa = 'read' WHERE id_mahasiswa = :user_id AND status_mahasiswa = 'unread'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user_id' => $user_id]);

                // Set the message and redirection URL for mahasiswa
                $message = "Notifications for Mahasiswa marked as read!";
            } else {
                $queryAdmin = "SELECT 'admin' AS source_table, id_admin AS user_id FROM admin WHERE username = :username";
                $stmt = $pdo->prepare($queryAdmin);
                $stmt->execute(['username' => $username]);
                $rowAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rowAdmin) {
                    $user_id = $rowAdmin['user_id'];
                    $sql = "UPDATE notif SET status_admin = 'read' WHERE admin = :user_id AND status_admin = 'unread'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['user_id' => $user_id]);
                    $message = "Notifications for Mahasiswa marked as read!";
                } else {
                    echo json_encode(['message' => 'User not found']);
                    exit;
                }
            }
        }

        if (!isset($error)) {
            $previousPage = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            if (!headers_sent()) {
                header("Location: " . $previousPage);
                exit();
            } else {
                echo "<script>window.location.href = '$previousPage';</script>";
                exit();
            }
        } else {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        
    } catch (PDOException $e) {
        // Error handling if query fails
        echo "<div class='alert alert-danger'>Database error: " . $e->getMessage() . "</div>";
    }
} else {
    // If the user is not logged in
    echo "<div class='alert alert-danger'>You are not logged in!</div>";
}
?>
