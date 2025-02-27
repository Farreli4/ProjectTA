<?php
require '../../vendor/autoload.php';
include "../../config/connection.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $fileTmpName = $_FILES['excel_file']['tmp_name'];
        $fileName = $_FILES['excel_file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($fileExtension == 'xlsx' || $fileExtension == 'xls') {
            $spreadsheet = IOFactory::load($fileTmpName);
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->getRowIterator() as $row) {
                $data = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $data[] = trim($cell->getValue()); // Trim spaces
                }

                // Debugging: Print extracted row data
                echo "<pre>";
                print_r($data);
                echo "</pre>";

                if (empty($data[0]) || empty($data[1]) || empty($data[5])) {
                    echo "Skipping row: Missing required values<br>";
                    continue;
                }

                if (count($data) >= 7) {
                    $hashedPass = password_hash($data[6], PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO mahasiswa (nama_mahasiswa, nim, prodi, kelas, nomor_telepon, username, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $hashedPass);
                    $stmt->execute();
                } else {
                    echo "Skipping row: Incomplete data<br>";
                }
            }

            echo "File successfully uploaded and data inserted!";
            $conn->close();
            header("Location: daftarMahasiswa.php"); // Remove space after "Location"
            exit(); // Ensure redirection works
        } else {
            echo "Please upload a valid Excel file.";
        }
    } else {
        echo "Error: No file uploaded or an upload error occurred.";
    }
}
?>
