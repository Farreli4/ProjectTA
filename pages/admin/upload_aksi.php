<?php
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    // Check if file is uploaded
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $fileTmpName = $_FILES['excel_file']['tmp_name'];
        $fileName = $_FILES['excel_file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow only Excel files
        if ($fileExtension == 'xlsx' || $fileExtension == 'xls') {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($fileTmpName);
            $sheet = $spreadsheet->getActiveSheet();

            // Connect to MySQL database
            $conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

            // Loop through the rows of the spreadsheet
            foreach ($sheet->getRowIterator() as $row) {
                $data = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                if (count($data) > 0) {
                    $stmt = $conn->prepare("INSERT INTO mahasiswa (nama_mahasiswa, nim, prodi, kelas, nomor_telepon, username, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
                    $stmt->execute();
                }
            }

            echo "File successfully uploaded and data inserted into database!";
            $conn->close();
            header("Location : daftarMahasiswa.php");
        } else {
            echo "Please upload a valid Excel file.";
        }
    } else {
        echo "Error: No file uploaded or there was an error with the upload.";
    }
}
?>
