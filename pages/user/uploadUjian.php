<!-- UploadUjian -->
<?php
// Ambil data mahasiswa dari session (sesuaikan dengan sistem login Anda)
session_start();
$nama_mahasiswa = $_SESSION['username'] ?? 'farel';
$conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function checkTAFilesStatus($nama_mahasiswa)
{
    $requiredFiles = [
        'Lembar Berita Acara (Foto, Buku Kehadiran, dll)'
    ];

    foreach ($requiredFiles as $file) {
        $status = getFileStatus($nama_mahasiswa, $file);
        if ($status !== 'Uploaded') {
            return false; // Ada file yang belum diupload
        }
    }
    return true; // Semua file sudah diupload
}

// Pengecekan status file di uploadTA
if (!checkTAFilesStatus($nama_mahasiswa)) {
    echo "<script>alert('Silakan lengkapi semua file pada Upload Seminar dan Upload Berita Acara terlebih dahulu.'); window.location.href='uploadBeritaAcara.php';</script>";
    exit();
}

// Mengubah query untuk mengambil nim dan nama_mahasiswa
$check = "SELECT nim, nama_mahasiswa, prodi FROM mahasiswa WHERE username = :nama";
$checkNim = $conn->prepare($check);
$checkNim->execute([':nama' => $nama_mahasiswa]);
$row = $checkNim->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $nim = $row['nim'];
    $nama = $row['nama_mahasiswa'];
    $prodi = $row['prodi'];
} else {
    $nim = 'K3522068';
    $nama = 'Nama Default';
    $prodi = 'PRODI';
    echo "NIM: " . $nim . "<br>";
    echo "Nama: " . $nama . "<br>";
    echo "Prodi: " . $prodi;
}



// Fungsi untuk mendapatkan status file dari database
function getFileStatus($nama_mahasiswa, $tipe_file)
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Tentukan nama kolom berdasarkan tipe file    
        $columnName = '';
        switch ($tipe_file) {
            case 'Lembar Persetujuan Laporan Tugas Akhir':
                $columnName = 'lembar_persetujuan_laporan_ta(ujian)';
                break;
            case 'Form Pendaftaran Ujian Tugas Akhir':
                $columnName = 'form_pendaftaran_ujian_ta(ujian)';
                break;
            case 'Lembar Kehadiran Seminar Proposal':
                $columnName = 'lembar_kehadiran_sempro(ujian)';
                break;
            case 'Buku Konsultasi Tugas Akhir':
                $columnName = 'buku_konsultasi_ta(ujian)';
                break;
            case 'Lembar Berita Acara (Foto, Buku Kehadiran, dll)':
                $columnName = 'lembar_berita_acara(seminar)';
                break;
        }

        // Cek apakah file sudah diupload
        $sql = "SELECT `$columnName` FROM mahasiswa WHERE username = :nama";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':nama' => $nama_mahasiswa]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result[$columnName] !== null ? 'Uploaded' : 'Belum Upload';
    } catch (PDOException $e) {
        return 'Error';
    }
}


$driveLinks = [
    'Lembar Persetujuan Laporan Tugas Akhir' => 'https://drive.google.com/your-link-1',
    'Form Pendaftaran Ujian Tugas Akhir' => 'https://drive.google.com/your-link-1',
    'Lembar Kehadiran Seminar Proposal' => 'https://drive.google.com/your-link-1',
    'Buku Konsultasi Tugas Akhir' => 'https://drive.google.com/your-link-1',
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../Template/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../../Template/skydash/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="../../assets/css/css/user.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/user/uploadUjian.css" />
    <script src="../../Template/skydash/vendors/js/vendor.bundle.base.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <!--NAVBAR KIRI-->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="dashboard.php"><img src="../../assets/img/logo2.png" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="../../assets/img/Logo.webp" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>

                <!--NAVBAR KANAN-->
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>

                        <!-- NOTIFIKASI -->
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        </div>
                    </li>

                    <!--PROFIL-->
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="../../assets/img/orang.png" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <div class="dropdown-header">
                                <div class="profile-pic mb-3 d-flex justify-content-center">
                                    <img src="../../assets/img/orang.png" alt="profile" class="rounded-circle" width="50" height="50" />
                                </div>
                                <div class="profile-info text-center">
                                    <p class="font-weight-bold mb-1"><?php echo htmlspecialchars($nama); ?></p>
                                    <p class="text-muted mb-1"><?php echo htmlspecialchars($nim); ?></p>
                                    <p class="text-muted mb-1"><?php echo htmlspecialchars($prodi); ?></p>
                                </div>
                            </div>
                            <!-- Garis pembatas -->
                            <div style="border-top: 1px solid #ddd; margin: 10px 0;"></div>
                            <a class="dropdown-item" href="../../login.php">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->

            <div id="right-sidebar" class="settings-panel">

                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                    </div>
                    <!-- To do section tab ends -->

                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panduan.php">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">Alur & Panduan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Upload Dokumen</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="uploadTA.php">Upload TA</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadSeminar.php">Upload Seminar</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadBeritaAcara.php">Upload Berita Acara</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadUjian.php">Upload Ujian</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadNilai.php">Upload Nilai</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Pengajuan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="pengajuanTA.php">Pengajuan TA</a></li>
                                <li class="nav-item"><a class="nav-link" href="pengajuanSeminar.php">Pengajuan Seminar</a></li>
                                <li class="nav-item"><a class="nav-link" href="pengajuanUjian.php">Pengajuan Ujian</a></li>
                                <li class="nav-item"><a class="nav-link" href="pengajuanNilai.php">Pengajuan Nilai</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hasilNilai.php">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Hasil Nilai</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lampiran.php">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">Lampiran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../login.php">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Log Out</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- MAIN-->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!--BOX-->
                    <div class="content-wrapper">
                        <h3 style="margin-bottom: 15px;">Welcome <span class="text-primary"><?php echo htmlspecialchars($nama); ?></span></h3>
                        <h6>NIM: <?php echo htmlspecialchars($nim); ?></h6>

                        <div class="alert-info">
                            Disini kamu dapat melakukan upload Jurnal Magang. Setelah Jurnal terupload,
                            tunggu 1-2 hari kerja sampai notifikasi berubah menjadi terverifikasi
                        </div>
                        <div class="upload-container">

                            <h4>Perhatikan petunjuk sebelum melakukan Upload:</h4>
                            <ul class="requirements-list">
                                <li>Upload Lembar Persetujuan Laporan Tugas Akhir (TA) yang sudah di tandatangani oleh Dosen Pembimbing 1 dan 2</li>
                                <li>Upload Lembar Kehadiran Seminar Proposal dengan minimal menghadiri 5x Seminar Proposal</li>
                                <li>Upload Surat dengan format <span style="color: red;">PDF</span></li>
                                <li>Format penamaan dokumen: NIM_Nama File_Nama (Contoh: K<?php echo htmlspecialchars($nim); ?>_Buku Konsultasi TA_Muhmmad Anthony)</li>
                                <li>Maksimal ukuran dokumen 2 Mb</li>
                                <li>Pastikan Jurnal Magang yang akan diupload sudah benar</li>
                            </ul>

                            <table class="file-table">
                                <thead>
                                    <tr>
                                        <th>NAMA FILE</th>
                                        <th>FILE</th>
                                        <th>STATUS</th>
                                        <th>DOWNLOAD FILE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $files = [
                                        'Lembar Persetujuan Laporan Tugas Akhir',
                                        'Form Pendaftaran Ujian Tugas Akhir',
                                        'Lembar Kehadiran Seminar Proposal',
                                        'Buku Konsultasi Tugas Akhir',
                                    ];

                                    foreach ($files as $file) {
                                        $status = getFileStatus($nama_mahasiswa, $file);
                                        $statusClass = '';
                                        switch ($status) {
                                            case 'Revisi':
                                                $statusClass = 'status-revisi';
                                                break;
                                            case 'Lulus':
                                                $statusClass = 'status-lulus';
                                                break;
                                            case 'Tolak':
                                                $statusClass = 'status-tolak';
                                                break;
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($file); ?></td>
                                            <td>
                                                <form action="" method="post" enctype="multipart/form-data" class="upload-form">
                                                    <div class="file-upload-wrapper">
                                                        <input type="file" name="file_upload" accept=".pdf"
                                                            id="file_<?php echo md5($file); ?>"
                                                            class="file-input"
                                                            onchange="updateFileName(this)">
                                                        <input type="hidden" name="file_type" value="<?php echo htmlspecialchars($file); ?>">
                                                        <div class="file-upload-controls">
                                                            <label for="file_<?php echo md5($file); ?>" class="select-file-btn">Pilih File</label>
                                                            <span class="selected-file-name" id="filename_<?php echo md5($file); ?>">Tidak ada file dipilih</span>
                                                            <button type="submit" class="upload-submit-btn">Upload</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td><span class="status <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                                            <td>
                                                <a href="<?php echo htmlspecialchars($driveLinks[$file]); ?>"
                                                    target="_blank"
                                                    class="download-btn"
                                                    rel="noopener noreferrer">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <script>
            // Add this JavaScript function
            function updateFileName(input) {
                const fileNameSpan = document.getElementById('filename_' + input.id.split('_')[1]);
                if (input.files && input.files[0]) {
                    const fileName = input.files[0].name;
                    fileNameSpan.textContent = fileName;
                } else {
                    fileNameSpan.textContent = 'Tidak ada file dipilih';
                }
            }
        </script>
        <?php
        // Proses upload file jika ada
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
            $file = $_FILES['file_upload'];
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileCategory = $_POST['file_type'] ?? '';

            // Validasi file
            if ($fileType != "pdf") {
                echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf, hanya file PDF yang diperbolehkan.',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'custom-popup-error',
                    title: 'custom-title-error',
                    htmlContainer: 'custom-text-error',
                    confirmButton: 'custom-button-error'
                }
            });
        </script>";
                return;
            }

            if ($file['size'] > 2000000) { // 2MB
                echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf, ukuran file terlalu besar (max 2MB).',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'custom-popup-error',
                    title: 'custom-title-error',
                    htmlContainer: 'custom-text-error',
                    confirmButton: 'custom-button-error'
                }
            });
        </script>";
                return;
            }

            try {
                // Koneksi ke database
                $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Baca file sebagai binary
                $fileContent = file_get_contents($file['tmp_name']);
                if ($fileContent === false) {
                    throw new Exception("Gagal membaca file");
                }

                // Tentukan nama kolom berdasarkan tipe file
                $columnName = '';
                switch ($fileCategory) {
                    case 'Lembar Persetujuan Laporan Tugas Akhir':
                        $columnName = 'lembar_persetujuan_laporan_ta(ujian)';
                        break;
                    case 'Form Pendaftaran Ujian Tugas Akhir':
                        $columnName = 'form_pendaftaran_ujian_ta(ujian)';
                        break;
                    case 'Lembar Kehadiran Seminar Proposal':
                        $columnName = 'lembar_kehadiran_sempro(ujian)';
                        break;
                    case 'Buku Konsultasi Tugas Akhir':
                        $columnName = 'buku_konsultasi_ta(ujian)';
                        break;
                    default:
                        throw new Exception("Kategori file tidak valid");
                }

                // Cek apakah data mahasiswa sudah ada
                $checkSql = "SELECT username FROM mahasiswa WHERE username = :nama";
                $checkStmt = $conn->prepare($checkSql);
                $checkStmt->execute([':nama' => $nama_mahasiswa]);

                if ($checkStmt->rowCount() > 0) {
                    // Update data yang sudah ada
                    $sql = "UPDATE mahasiswa SET `$columnName` = :file_content WHERE username = :nama";
                } else {
                    // Insert data baru dengan kolom minimal yang diperlukan
                    $sql = "INSERT INTO mahasiswa (nama_mahasiswa, `$columnName`) 
                   VALUES (:nama, :file_content)";
                }

                $stmt = $conn->prepare($sql);
                $params = [
                    ':nama' => $nama_mahasiswa,
                    ':file_content' => $fileContent
                ];

                // Tambahkan parameter nama jika melakukan INSERT
                if ($checkStmt->rowCount() == 0) {
                    $params[':nama'] = $nama_mahasiswa;
                }

                $result = $stmt->execute($params);

                if ($result) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'File berhasil diupload.',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'custom-popup-success',
                                title: 'custom-title-success',
                                htmlContainer: 'custom-text-success',
                                confirmButton: 'custom-button-success'
                            },
                            showClass: {
                                popup: ''
                            },
                            hideClass: {
                                popup: ''
                            },
                            didOpen: () => {
                                // Menyembunyikan efek animasi saat logo muncul
                                const popup = Swal.getPopup();
                                popup.style.animation = 'none';
                            }
                        });
                    </script>";
                } else {
                    throw new Exception("Gagal menyimpan ke database");
                }
                
                } catch (Exception $e) {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: " . $e->getMessage() . "',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'custom-popup-error',
                                title: 'custom-title-error',
                                htmlContainer: 'custom-text-error',
                                confirmButton: 'custom-button-error'
                            },
                            showClass: {
                                popup: ''
                            },
                            hideClass: {
                                popup: ''
                            },
                            didOpen: () => {
                                // Menyembunyikan efek animasi saat logo muncul
                                const popup = Swal.getPopup();
                                popup.style.animation = 'none';
                            }
                        });
                    </script>";
                }
                
        }
        ?>
        <style>
    .swal2-popup.custom-popup-success {
        background-color:rgba(40, 167, 70, 0.57) !important; /* Hijau */
        color: white !important;
    }

    .swal2-popup.custom-popup-error {
        background-color: #dc3545 !important; /* Merah */
        color: white !important;
    }

    .swal2-title.custom-title-success, .swal2-title.custom-title-error {
        color: white !important;
    }

    .swal2-html-container.custom-text-success, .swal2-html-container.custom-text-error {
        color: white !important;
    }

    .swal2-confirm.custom-button-success {
        background-color:rgba(33, 136, 55, 0.54) !important; /* Hijau lebih gelap */
        color: white !important;
    }

    .swal2-confirm.custom-button-error {
        background-color: #c82333 !important; /* Merah lebih gelap */
        color: white !important;
    }
</style>
        <!-- plugins:js -->
        <script src="../../Template/skydash/vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="../../Template/skydash/vendors/chart.js/Chart.min.js"></script>
        <script src="../../Template/skydash/vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="../../Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="../../Template/skydash/js/dataTables.select.min.js"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="../../Template/skydash/js/off-canvas.js"></script>
        <script src="../../Template/skydash/js/hoverable-collapse.js"></script>
        <script src="../../Template/skydash/js/../../Template.js"></script>
        <script src="../../Template/skydash/js/settings.js"></script>
        <script src="../../Template/skydash/js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="../../Template/skydash/js/dashboard.js"></script>
        <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
        <!-- End custom js for this page-->

</html>