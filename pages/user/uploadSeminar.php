<!-- UploadSeminar -->
<?php
// Ambil data mahasiswa dari session (sesuaikan dengan sistem login Anda)
session_start();
function showNotification($type, $message)
{
    $_SESSION['notification'] = [
        'type' => $type,
        'message' => $message
    ];
}
$nama_mahasiswa = $_SESSION['username'] ?? 'farel';
$conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function checkTAFilesStatus($nama_mahasiswa)
{
    $requiredFiles = [
        'Form Pendaftaran dan Persetujuan Tema',
        'Bukti Pembayaran',
        'Bukti Transkrip Nilai',
        'Bukti Kelulusan Mata kuliah Magang / PI',
    ];

    foreach ($requiredFiles as $file) {
        $status = getFileStatus($nama_mahasiswa, $file);
        if ($status !== 'Uploaded') {
            return false; // Ada file yang belum diupload
        }
    }
    return true; // Semua file sudah diupload
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

// Proses upload file jika ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $file = $_FILES['file_upload'];
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileCategory = $_POST['file_type'] ?? '';

    // Format nama file
    $newFileName = $nama_mahasiswa . '_' . str_replace(' ', '_', $fileCategory) . '_' . $nama_mahasiswa . '.' . $fileType;

    // Validasi file
    if ($fileType != "pdf") {
        showNotification('error', 'Maaf, hanya file PDF yang diperbolehkan.');
    } elseif ($file['size'] > 2000000) { // 2MB
        showNotification('error', 'Maaf, ukuran file terlalu besar (maksimal 2MB).');
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
            case 'Form Pendaftaran Seminar Proposal':
                $columnName = 'form_pendaftaran_sempro(seminar)';
                break;
            case 'Lembar Persetujuan Proposal Tugas Akhir':
                $columnName = 'lembar_persetujuan_proposal_ta(seminar)';
                break;
            case 'Buku Konsultasi TA':
                $columnName = 'buku_konsultasi_ta(seminar)';
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
            showNotification('success', 'File berhasil diupload! Silakan tunggu verifikasi dari admin.');
        } else {
            throw new Exception("Gagal menyimpan ke database");
        }
    } catch (Exception $e) {
        showNotification('error', 'Error: ' . $e->getMessage());
    }
}

// Fungsi untuk mendapatkan status file dari database
function getFileStatus($nama_mahasiswa, $fileCategory)
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Tentukan nama kolom berdasarkan tipe file    
        $columnName = '';
        switch ($fileCategory) {
            case 'Form Pendaftaran Seminar Proposal':
                $columnName = 'form_pendaftaran_sempro(seminar)';
                break;
            case 'Lembar Persetujuan Proposal Tugas Akhir':
                $columnName = 'lembar_persetujuan_proposal_ta(seminar)';
                break;
            case 'Buku Konsultasi TA':
                $columnName = 'buku_konsultasi_ta(seminar)';
                break;
            case 'Form Pendaftaran dan Persetujuan Tema':
                $columnName = 'form_pendaftaran_persetujuan_tema(TA)';
                break;
            case 'Bukti Pembayaran':
                $columnName = 'bukti_pembayaran(TA)';
                break;
            case 'Bukti Transkrip Nilai':
                $columnName = 'bukti_transkip_nilai(TA)';
                break;
            case 'Bukti Kelulusan Mata kuliah Magang / PI':
                $columnName = 'bukti_kelulusan_magang(TA)';
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
    'Form Pendaftaran Seminar Proposal' => 'https://drive.google.com/your-link-1',
    'Lembar Persetujuan Proposal Tugas Akhir' => 'https://drive.google.com/your-link-2',
    'Buku Konsultasi TA' => 'https://drive.google.com/your-link-3'
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
    <link rel="stylesheet" type="text/css" href="../../assets/css/user/uploadSeminar.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
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
                            <a class="dropdown-item" href="../../index.php">
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
                        <a class="nav-link" href="../../index.php">
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
                                        $status = getFileStatus($nama_mahasiswa, $file);
                                        $statusClass = '';
                                        $statusText = $status;
                                        switch ($status) {
                                            case 'Uploaded':
                                                $statusClass = 'status-uploaded';
                                                break;
                                            case 'Belum Upload':
                                                $statusClass = 'status-pending';
                                                break;
                                            case 'Revisi':
                                                $statusClass = 'status-revisi';
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
        <script>
            // Function to show notifications
            function showToast(type, message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // Function to handle file upload
            function handleFileUpload(formElement) {
                const fileInput = formElement.querySelector('input[type="file"]');
                const file = fileInput.files[0];

                if (!file) {
                    showToast('error', 'Silakan pilih file terlebih dahulu');
                    return false;
                }

                if (file.size > 2000000) {
                    showToast('error', 'Ukuran file terlalu besar (maksimal 2MB)');
                    return false;
                }

                if (!file.type.includes('pdf')) {
                    showToast('error', 'Hanya file PDF yang diperbolehkan');
                    return false;
                }

                // Show loading state
                Swal.fire({
                    title: 'Mengupload File...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                return true;
            }

            // Add event listeners to all upload forms
            document.querySelectorAll('.upload-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!handleFileUpload(this)) {
                        e.preventDefault();
                    }
                });
            });

            // Check for PHP notifications on page load
            <?php if (isset($_SESSION['notification'])): ?>
                showToast('<?php echo $_SESSION['notification']['type']; ?>',
                    '<?php echo $_SESSION['notification']['message']; ?>');
                <?php unset($_SESSION['notification']); ?>
            <?php endif; ?>
        </script>
        <?php
        if (!checkTAFilesStatus($nama_mahasiswa)) {
        ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Silakan lengkapi semua file pada Upload Tugas Akhir (TA) terlebih dahulu.',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'custom-popup', // Class untuk modal
                            title: 'custom-title', // Class untuk judul
                            htmlContainer: 'custom-text', // Class untuk teks
                            confirmButton: 'custom-button' // Class untuk tombol
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'uploadTA.php';
                        }
                    });
                });

                // Tambahkan CSS langsung di dalam script
                const style = document.createElement('style');
                style.innerHTML = `
        .custom-popup {
            padding: 2rem !important;
            background: rgba(208, 13, 13, 0.7) !important; /* Background merah transparan */
            color: white !important; /* Warna teks putih */
            border-radius: 10px; /* Tambahkan sudut melengkung */
        }

        .custom-title {
            color: white !important; /* Warna judul putih */
        }

        .custom-text {
            color: white !important; /* Warna teks putih */
        }

        .custom-button {
            background-color: white !important; /* Tombol putih */
            color: red !important; /* Warna teks tombol merah */
            font-weight: bold;
        }

        .custom-button:hover {
            background-color: #ffcccc !important; /* Warna tombol saat hover */
        }
    `;
                document.head.appendChild(style);
            </script>

        <?php
        }
        ?>
        <style>
            /* Add these styles to your CSS */
            .swal2-popup.swal2-toast {
                padding: 0.75em 1em;
                background: #fff;
                box-shadow: 0 0 1em rgba(0, 0, 0, 0.1);
            }

            .swal2-popup.swal2-toast .swal2-title {
                margin: 0.5em;
                font-size: 1em;
                color: #333;
            }

            .swal2-popup.swal2-toast.swal2-icon-success {
                border-left: 4px solid #28a745;
            }

            .swal2-popup.swal2-toast.swal2-icon-error {
                border-left: 4px solid #dc3545;
            }

            .swal2-popup.swal2-toast.swal2-icon-warning {
                border-left: 4px solid #ffc107;
            }

            .swal2-popup.swal2-toast.swal2-icon-info {
                border-left: 4px solid #17a2b8;
            }

            .status {
                padding: 6px 12px;
                border-radius: 4px;
                font-weight: 500;
                font-size: 14px;
                display: inline-block;
            }

            .status-uploaded {
                background-color: #e8f5e9;
                color: #2e7d32;
                border: 1px solid #a5d6a7;
            }

            .status-pending {
                background-color: #fff3e0;
                color: #ef6c00;
                border: 1px solid #ffcc80;
            }

            .status-revisi {
                background-color: #e3f2fd;
                color: #1565c0;
                border: 1px solid #90caf9;
            }

            .status-tolak {
                background-color: #ffebee;
                color: #c62828;
                border: 1px solid #ef9a9a;
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
</body>

</html>