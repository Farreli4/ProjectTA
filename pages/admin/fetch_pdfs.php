<?php
require "../../config/connection.php";

$event = $_POST['event'];
$userId = $_POST['userId'];

// Define document columns for each event
$documents = [];
if ($event == "seminar_proposal") { 
    $documents = [
        "lembar_persetujuan_proposal_ta_seminar", 
        "buku_konsultasi_ta_seminar", 
        "lembar_berita_acara_seminar", 
        "form_pendaftaran_sempro_seminar"
    ];
} elseif ($event == "tugas_akhir") {
    $documents = [
        "form_pendaftaran_ta", 
        "form_persetujuan_ta", 
        "bukti_pembayaran_ta", 
        "bukti_transkip_nilai_ta", 
        "bukti_kelulusan_magang_ta"
    ];
} elseif ($event == "ujian") {
    $documents = [
        "lembar_persetujuan_laporan_ta_ujian", 
        "lembar_kehadiran_sempro_ujian", 
        "buku_konsultasi_ta_ujian"
    ];
} else {
    die("Invalid event selected.");
}

// Gunakan backtick untuk mengapit nama kolom yang mengandung tanda kurung
$docColumns = implode(", ", array_map(fn($col) => "m.`$col`", $documents));
$verificationColumns = implode(", ", array_map(fn($col) => "e.`$col` AS `verified_$col`", $documents));

// Fetch document data from `mahasiswa` and verification status from the event table
$query = "SELECT m.id_mahasiswa, $docColumns, $verificationColumns 
          FROM mahasiswa m
          LEFT JOIN $event e ON m.id_mahasiswa = e.id_mahasiswa
          WHERE m.id_mahasiswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$output = "<ul>";
foreach ($documents as $columnName) {
    $fileData = $row[$columnName];
    $verifiedColumn = "verified_" . $columnName;

    $downloadButton = (!empty($fileData)) ? 
        "<a href='download2.php?id=$userId&column=$columnName' class='download-btn'>⬇ Download</a>" : 
        "<span style='color: red;'>No File</span>";

    $verified = (!empty($row[$verifiedColumn]) && $row[$verifiedColumn] == 1) ? 
        "✔ Verified" : 
        "<button class='verify-btn' data-userid='$userId' data-event='$event' data-column='$columnName'>Verify</button>";

    $output .= "<tr><td>$columnName</td> <td>$verified</td> <td>$downloadButton</td></tr></li>";
}
$output .= "</ul>";

echo $output;
?>
