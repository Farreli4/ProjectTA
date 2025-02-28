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
        "form_pendaftaran_sempro_seminar",
        "lembar_persetujuan_laporan_ta_ujian", 
        "lembar_kehadiran_sempro_ujian", 
        "buku_konsultasi_ta_ujian",
        "form_pendaftaran_ujian_ta_ujian",
    ];
} elseif ($event == "tugas_akhir") {
    $documents = [
        "form_pendaftaran_persetujuan_tema_ta",
        "bukti_pembayaran_ta", 
        "bukti_transkip_nilai_ta", 
        "bukti_kelulusan_magang_ta"
    ];
} elseif ($event == "ujian") {
    $documents = [
        "lembar_persetujuan_laporan_ta_ujian", 
        "lembar_kehadiran_sempro_ujian", 
        "buku_konsultasi_ta_ujian",
        "form_pendaftaran_ujian_ta_ujian",
        "lembar_hasil_nilai_dosbim1_nilai",
        "lembar_hasil_nilai_dosbim2_nilai"
    ];
} else {
    die("Invalid event selected.");
}

$docColumns = implode(", ", array_map(fn($col) => "m.`$col`", $documents));
$verificationColumns = implode(", ", array_map(fn($col) => "v.`$col` AS `verified_$col`", $documents));

$query = "SELECT m.id_mahasiswa, $docColumns, $verificationColumns 
          FROM mahasiswa m
          LEFT JOIN verifikasi_dokumen v ON m.id_mahasiswa = v.id_mahasiswa
          WHERE m.id_mahasiswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$output = "<ul>";
foreach ($documents as $columnName) {
    $fileData = $row[$columnName] ?? null;
    $verifiedColumn = "verified_" . $columnName;

    $downloadButton = (!empty($fileData)) ? 
        "<a href='download.php?id=$userId&column=$columnName' class='download-btn'>⬇ Download</a>" : 
        "<span style='color: red;'>No File</span>";

    $verified = (!empty($row[$verifiedColumn]) && $row[$verifiedColumn] == 1) ? 
        "✔ Verified" : 
        "<button class='verify-btn' data-userid='$userId' data-event='$event' data-column='$columnName'>Verify</button>";

    $output .= "<tr><td>$columnName</td> <td>$verified</td> <td>$downloadButton</td></tr>";
}
$output .= "</ul>";

echo $output;
?>
