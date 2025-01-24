<?php
// Ambil data mahasiswa dari session (sesuaikan dengan sistem login Anda)
session_start();
$nama_mahasiswa = $_SESSION['nama'] ?? 'Mahasiswa'; // Default jika tidak ada session
$nim = $_SESSION['nim'] ?? '12345678';

// Fungsi untuk mendapatkan status file dari database
function getFileStatus($nim, $tipe_file)
{
    // Ini contoh, sesuaikan dengan database Anda
    return "Revisi"; // atau "Lulus" atau "Tolak"
}

// Proses upload file jika ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $uploadDir = 'uploads/';  // Buat folder 'uploads' di direktori yang sama

    // Pastikan direktori upload ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['file_upload'];
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileCategory = $_POST['file_type'] ?? '';

    // Format nama file
    $newFileName = $nim . '_' . str_replace(' ', '_', $fileCategory) . '_' . $nama_mahasiswa . '.' . $fileType;
    $uploadPath = $uploadDir . $newFileName;

    // Validasi file
    if ($fileType != "pdf") {
        echo "<script>alert('Maaf, hanya file PDF yang diperbolehkan.');</script>";
    } elseif ($file['size'] > 2000000) { // 2MB
        echo "<script>alert('Maaf, ukuran file terlalu besar (max 2MB).');</script>";
    } else {
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo "<script>alert('File berhasil diupload.');</script>";
        } else {
            echo "<script>alert('Maaf, terjadi error saat upload file.');</script>";
        }
    }
}

$driveLinks = [
    'Form Pendaftaran Seminar Proposal' => 'https://drive.google.com/your-link-1',
    'Lembar Persetujuan Proposal Tugas Akhir' => 'https://drive.google.com/your-link-1',
    'Buku Konsultasi TA' => 'https://drive.google.com/your-link-2',
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
    <style>
        .download-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ffffff;
            color: #6C63FF;
            border: 1px solid #6C63FF;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background-color: #6C63FF;
            color: #ffffff;
            text-decoration: none;
        }

        /* Menambahkan style untuk visited state */
        .download-btn:visited {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ffffff;
            color: #6C63FF;
            border: 1px solid #6C63FF;
            border-radius: 4px;
            text-decoration: none;
        }

        /* Menambahkan style untuk active state */
        .download-btn:active {
            background-color: #5850e6;
            color: #ffffff;
        }

        /* Menambahkan style untuk focus state */
        .download-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(108, 99, 255, 0.2);
        }
    </style>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <!--NAVBAR KIRI-->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="images/logo.svg" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
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
                            <img src="images/faces/face28.jpg" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
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
                                <li class="nav-item"> <a class="nav-link" href="uploadSeminar">Upload Sempro</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadUjian.php">Upload Ujian</a></li>
                                <li class="nav-item"> <a class="nav-link" href="lampiran">Lampiran</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengajuanTA.php">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan TA</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengajuanSeminar.php">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan Seminar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengajuanUjian.php">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan Ujian</span>
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
                        <h3>Welcome <?php echo htmlspecialchars($nama_mahasiswa); ?></h3>
                        <h6>NIM: <?php echo htmlspecialchars($nim); ?></h6>

                        <div class="alert-info">
                            Disini kamu dapat melakukan upload Jurnal Magang. Setelah Jurnal terupload,
                            tunggu 1-2 hari kerja sampai notifikasi berubah menjadi terverifikasi
                        </div>
                        <div class="upload-container">

                            <h4>Perhatikan petunjuk sebelum melakukan Upload:</h4>
                            <ul class="requirements-list">
                                <li>Upload Form Pendaftaran Seminar Proposal yang sudah di tandatangani</li>
                                <li>Upload Lembar Persetujuan Proposal Tugas Akhir yang sudah di tandatangani Dosen Pembimbing TA</li>
                                <li>Upload Buku Konsultasi TA yang sudah diisi Bimbingan</li>
                                <li>Upload Surat dengan format <span style="color: red;">PDF</span></li>
                                <li>Format penamaan dokumen: NIM_Nama File_Nama (Contoh: K<?php echo htmlspecialchars($nim); ?>_Buku Konsultasi TA_Muhammad Anthony)</li>
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
                                        'Form Pendaftaran Seminar Proposal',
                                        'Lembar Persetujuan Proposal Tugas Akhir',
                                        'Buku Konsultasi TA',
                                    ];

                                    foreach ($files as $file) {
                                        $status = getFileStatus($nim, $file);
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
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="file_upload" accept=".pdf" style="display: none;" id="file_<?php echo md5($file); ?>">
                                                    <input type="hidden" name="file_type" value="<?php echo htmlspecialchars($file); ?>">
                                                    <button type="button" class="upload-btn" onclick="document.getElementById('file_<?php echo md5($file); ?>').click()">Upload</button>
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

                    <!-- Process Upload -->
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['jurnal'])) {
                        $uploadDir = 'uploads/';
                        $uploadFile = $uploadDir . basename($_FILES['jurnal']['name']);

                        // Validasi file
                        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                        if ($fileType != "pdf") {
                            echo "<script>alert('Maaf, hanya file PDF yang diperbolehkan.');</script>";
                        } elseif ($_FILES["jurnal"]["size"] > 2000000) { // 2MB
                            echo "<script>alert('Maaf, ukuran file terlalu besar (max 2MB).');</script>";
                        } else {
                            if (move_uploaded_file($_FILES['jurnal']['tmp_name'], $uploadFile)) {
                                echo "<script>alert('File berhasil diupload.');</script>";
                                // Di sini Anda bisa menambahkan kode untuk update database
                            } else {
                                echo "<script>alert('Maaf, terjadi error saat upload file.');</script>";
                            }
                        }
                    }
                    ?>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

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
</body>

</html>