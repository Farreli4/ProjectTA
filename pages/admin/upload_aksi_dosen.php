<?php
require '../../vendor/autoload.php';
include '../../config/connection.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $fileTmpName = $_FILES['excel_file']['tmp_name'];
        $fileName = $_FILES['excel_file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow only Excel files
        if ($fileExtension == 'xlsx' || $fileExtension == 'xls') {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($fileTmpName);
            $sheet = $spreadsheet->getActiveSheet();

            // Loop through the rows of the spreadsheet
            foreach ($sheet->getRowIterator() as $row) {
                $data = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Pastikan ada data yang cukup sebelum menggunakan indeks tertentu
                if (count($data) >= 6) {
                    $hashedPass = password_hash($data[5], PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO dosen_pembimbing (nama_dosen, nip, prodi, nomor_telepon, username, pass) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $data[0], $data[1], $data[2], $data[3], $data[4], $hashedPass);
                    $stmt->execute();
                }
            }

            // Redirect tanpa mengirim output terlebih dahulu
            $conn->close();
            header("Location: daftarDosen.php");
            exit();
        } else {
            echo "Please upload a valid Excel file.";
        }
    } else {
        echo "Error: No file uploaded or there was an error with the upload.";
    }
}
?>
