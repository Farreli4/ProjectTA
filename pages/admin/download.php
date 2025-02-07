<?php
// Enable error reporting to display any potential errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to your database
$conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if there's an ID parameter
if (isset($_GET['id'])) {
    $file_id = $_GET['id']; // Get the file ID from the URL

    // Prepare the SQL query to get the file data from the database
    $sql = "SELECT form_pendaftaran, bukti_transkip, sistem_magang FROM mahasiswa WHERE id_mahasiswa = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($form_pendaftaran, $bukti_transkip, $sistem_magang);

    // Debugging output to check if data is being fetched
    if ($stmt->fetch()) {
        echo "Data fetched successfully.<br>";

        // Show the lengths of the BLOBs (Binary Data)
        echo "Form Pendaftaran (length): " . (empty($form_pendaftaran) ? "No file" : strlen($form_pendaftaran)) . " bytes<br>";
        echo "Bukti Transkip (length): " . (empty($bukti_transkip) ? "No file" : strlen($bukti_transkip)) . " bytes<br>";
        echo "Sistem Magang (length): " . (empty($sistem_magang) ? "No file" : strlen($sistem_magang)) . " bytes<br>";
    } else {
        echo "No data found for the provided ID.<br>";
    }

    // Determine which file to send based on the request
    $file = null;
    $file_name = '';

    if (!empty($form_pendaftaran)) {
        $file = $form_pendaftaran;
        $file_name = 'Form_Pendaftaran.pdf';
    } elseif (!empty($bukti_transkip)) {
        $file = $bukti_transkip;
        $file_name = 'Bukti_Transkip.pdf';
    } elseif (!empty($sistem_magang)) {
        $file = $sistem_magang;
        $file_name = 'Sistem_Magang.pdf';
    }

    if ($file) {
        // Set headers for download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        header("Content-Length: " . strlen($file));
        echo $file;
    } else {
        echo "No file found!";
    }

    $stmt->close();
} else {
    echo "No ID parameter provided!";
}

$conn->close();
?>
