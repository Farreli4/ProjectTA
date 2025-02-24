<?php
session_start();
$nama_mahasiswa = $_SESSION['username'] ?? 'farel';
$event = 'seminar_proposal';

try {
    $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get student info
    $check = "SELECT id_mahasiswa, nim, nama_mahasiswa, prodi FROM mahasiswa WHERE username = :nama";
    $checkNim = $conn->prepare($check);
    $checkNim->execute([':nama' => $nama_mahasiswa]);
    $row = $checkNim->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nim = $row['nim'];
        $nama = $row['nama_mahasiswa'];
        $prodi = $row['prodi'];
        $id = $row['id_mahasiswa'];
    } else {
        $nim = 'K3522068';
        $nama = 'Nama Default';
        $prodi = 'PRODI';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function checkTAVerificationStatus($nama_mahasiswa)
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get student ID first
        $stmt = $conn->prepare("SELECT id_mahasiswa FROM mahasiswa WHERE username = :nama");
        $stmt->execute([':nama' => $nama_mahasiswa]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        $id = $result['id_mahasiswa'];

        // Check verification status for all required TA documents
        $sql = "SELECT 
            form_pendaftaran_persetujuan_tema_ta,
            bukti_pembayaran_ta,
            bukti_transkip_nilai_ta,
            bukti_kelulusan_magang_ta
        FROM verifikasi_dokumen
        WHERE id_mahasiswa = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $verificationStatus = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($verificationStatus) {
            return array_sum($verificationStatus) === count($verificationStatus);
        }

        return false;
    } catch (PDOException $e) {
        error_log("Error checking TA verification: " . $e->getMessage());
        return false;
    }
}

// Function untuk mengecek dokumen seminar
function checkSeminarDocsVerification($nama_mahasiswa)
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id_mahasiswa FROM mahasiswa WHERE username = :nama");
        $stmt->execute([':nama' => $nama_mahasiswa]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        $id = $result['id_mahasiswa'];

        $sql = "SELECT 
            form_pendaftaran_sempro_seminar,
            lembar_persetujuan_proposal_ta_seminar,
            buku_konsultasi_ta_seminar
        FROM verifikasi_dokumen
        WHERE id_mahasiswa = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $verificationStatus = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($verificationStatus) {
            return array_sum($verificationStatus) === count($verificationStatus);
        }

        return false;
    } catch (PDOException $e) {
        error_log("Error checking seminar verification: " . $e->getMessage());
        return false;
    }
}

// Add restriction check based on page
$currentPage = basename($_SERVER['PHP_SELF']);

if ($currentPage === 'pengajuanSeminar.php') {
    if (!checkTAVerificationStatus($nama_mahasiswa)) {
?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Pastikan Semua dokumen pada page pengajuan Tugas Akhir terverifikasi, lalu submit pengajuan terlebih dahulu.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pengajuanTA.php';
                    }
                });
            });
        </script>
    <?php
        exit();
    }
} else if ($currentPage === 'pengajuanUjian.php') {
    if (!checkTAVerificationStatus($nama_mahasiswa) || !checkSeminarDocsVerification($nama_mahasiswa)) {
    ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Anda harus menyelesaikan verifikasi dokumen TA dan Seminar terlebih dahulu.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pengajuanSeminar.php';
                    }
                });
            });
        </script>
<?php
        exit();
    }
}
// Function to get document status
function getDocumentStatus($nama_mahasiswa, $id, $document_type)
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mapping document name to column
        $columnMap = [
            'Form Pendaftaran Seminar Proposal' => 'form_pendaftaran_sempro_seminar',
            'Lembar Persetujuan Proposal Tugas Akhir' => 'lembar_persetujuan_proposal_ta_seminar',
            'Buku Konsultasi Tugas Akhir' => 'buku_konsultasi_ta_seminar',
        ];

        if (!isset($columnMap[$document_type])) {
            return 'Dokumen tidak valid';
        }

        $column = $columnMap[$document_type];

        // Step 1: Check verification status in tugas_akhir
        $sql2 = "SELECT `$column` FROM verifikasi_dokumen WHERE id_mahasiswa = :id";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([':id' => $id]);
        $verify = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($verify && $verify[$column] == 1) {
            return 'Terverifikasi'; // If verification status is 1
        }

        // Step 2: Check if the file exists in mahasiswa
        $sql = "SELECT `$column` FROM mahasiswa WHERE username = :nama";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':nama' => $nama_mahasiswa]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result[$column])) {
            return 'Menunggu Verifikasi'; // File exists & verification is 0
        }

        return 'Belum Upload'; // No file & verification = 0
    } catch (PDOException $e) {
        return 'Error: ' . $e->getMessage();
    }
}

function areAllDocumentsVerified($nama_mahasiswa, $id)
{
    $documents = [
        'Form Pendaftaran Seminar Proposal',
        'Lembar Persetujuan Proposal Tugas Akhir',
        'Buku Konsultasi Tugas Akhir'
    ];

    foreach ($documents as $doc) {
        $status = getDocumentStatus($nama_mahasiswa, $id, $doc);
        if ($status !== 'Terverifikasi') {
            return false;
        }
    }
    return true;
}
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
    <link rel="stylesheet" href="../../assets/css/css/pengajuan.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/user/pengajuan.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-warning">
            <?php
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>
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

                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <div id="notifications">
                                <script>
                                    function fetchNotifications() {
                                        $.ajax({
                                            url: '../../fetch_notif.php',
                                            method: 'GET',
                                            success: function(data) {
                                                const notifications = JSON.parse(data);
                                                const notificationCount = $('#notificationCount');
                                                const notificationList = $('#notifications');

                                                notificationCount.text(notifications.length);
                                                notificationList.empty();

                                                if (notifications.length === 0 || notifications.message === 'No unread notifications') {
                                                    notificationList.append(`
                        <a class="dropdown-item preview-item">
                          <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal"></h6>
                          </div>
                        </a>
                      `);
                                                } else {
                                                    notifications.forEach(function(notification) {
                                                        const notificationItem = `
                        <a class="dropdown-item preview-item" data-notification-id="${notification.id}">
                          <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                              <i class="ti-info-alt mx-0"></i>
                            </div>
                          </div>
                          <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">${notification.message}</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">${timeAgo(notification.created_at)}</p>
                          </div>
                        </a>
                        `;
                                                        notificationList.append(notificationItem);
                                                    });
                                                }
                                            },
                                            error: function() {
                                                console.log("Error fetching notifications.");
                                            }
                                        });
                                    }

                                    function timeAgo(time) {
                                        const timeAgo = new Date(time);
                                        const currentTime = new Date();
                                        const diffInSeconds = Math.floor((currentTime - timeAgo) / 1000);

                                        if (diffInSeconds < 60) {
                                            return `${diffInSeconds} seconds ago`;
                                        }
                                        const diffInMinutes = Math.floor(diffInSeconds / 60);
                                        if (diffInMinutes < 60) {
                                            return `${diffInMinutes} minutes ago`;
                                        }
                                        const diffInHours = Math.floor(diffInMinutes / 60);
                                        if (diffInHours < 24) {
                                            return `${diffInHours} hours ago`;
                                        }
                                        const diffInDays = Math.floor(diffInHours / 24);
                                        return `${diffInDays} days ago`;
                                    }

                                    $(document).on('click', '.dropdown-item', function() {
                                        const notificationId = $(this).data('notification-id');
                                        markNotificationAsRead(notificationId);
                                    });

                                    function markNotificationAsRead(notificationId) {
                                        $.ajax({
                                            url: '../../mark_read.php',
                                            method: 'POST',
                                            data: {
                                                id: notificationId
                                            },
                                            success: function(response) {
                                                console.log(response);
                                                fetchNotifications();
                                            },
                                            error: function() {
                                                console.log("Error marking notification as read.");
                                            }
                                        });
                                    }

                                    $(document).ready(function() {
                                        fetchNotifications();
                                        setInterval(fetchNotifications, 30000);
                                    });
                                </script>
                            </div>
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
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pengajuan Seminar</h4>
                                    <p class="card-description">Status Dokumen Pengajuan Seminar</p>

                                    <div class="status-grid">
                                        <?php
                                        $documents = [
                                            'Form Pendaftaran Seminar Proposal',
                                            'Lembar Persetujuan Proposal Tugas Akhir',
                                            'Buku Konsultasi Tugas Akhir',
                                        ];

                                        foreach ($documents as $doc) {
                                            $status = getDocumentStatus($nama_mahasiswa, $id, $doc);
                                            $statusClass = '';

                                            switch ($status) {
                                                case 'Terverifikasi':
                                                    $statusClass = 'status-verified';
                                                    break;
                                                case 'Menunggu Verifikasi':
                                                    $statusClass = 'status-pending';
                                                    break;
                                                default:
                                                    $statusClass = 'status-missing';
                                            }
                                        ?>
                                            <div class="status-box">
                                                <div class="status-title"><?php echo htmlspecialchars($doc); ?></div>
                                                <span class="status-badge <?php echo $statusClass; ?>">
                                                    <?php echo $status; ?>
                                                </span>
                                                <div class="status-date">
                                                    Last updated: <?php echo date('d M Y'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php if (isset($_POST['submit_pengajuan'])): ?>
                                        <div class="alert alert-success mt-4">
                                            Pengajuan berhasil dikirim! Menunggu verifikasi admin.
                                        </div>
                                    <?php endif; ?>

                                    <div class="submit-section">
                                        <?php
                                        $allVerified = areAllDocumentsVerified($nama_mahasiswa, $id);
                                        ?>
                                        <form action="addSiswa.php" method="post" id="pengajuanForm">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="event" value="<?php echo $event; ?>">
                                            <button type="submit" name="submit_pengajuan" class="btn-submit" id="submitBtn"
                                                <?php echo !$allVerified ? 'disabled' : ''; ?>>
                                                Submit Pengajuan
                                            </button>
                                        </form>
                                        <div id="verificationAlert" class="alert alert-warning mt-3" style="display: none;">
                                            Mohon maaf, semua dokumen harus terverifikasi sebelum dapat melakukan pengajuan.
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container-scroller -->
            <script>
                function showNotification() {
                    const notification = document.getElementById('notification');
                    notification.style.display = 'block';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 3000);
                }

                // Show notification if form was submitted
                <?php if (isset($_POST['submit_pengajuan'])): ?>
                    showNotification();
                <?php endif; ?>
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('pengajuanForm');
                    const submitBtn = document.getElementById('submitBtn');
                    const verificationAlert = document.getElementById('verificationAlert');
                    const isAllVerified = <?php echo $allVerified ? 'true' : 'false' ?>;

                    form.addEventListener('submit', function(e) {
                        if (!isAllVerified) {
                            e.preventDefault();
                            verificationAlert.style.display = 'block';
                            setTimeout(() => {
                                verificationAlert.style.display = 'none';
                            }, 3000);
                        }
                    });

                    // Add visual feedback for disabled button
                    if (!isAllVerified) {
                        submitBtn.style.opacity = '0.6';
                        submitBtn.style.cursor = 'not-allowed';
                    }
                });
            </script>

            <style>
                .alert-warning {
                    color: #856404;
                    background-color: #fff3cd;
                    border-color: #ffeeba;
                    padding: .75rem 1.25rem;
                    margin-bottom: 1rem;
                    border: 1px solid transparent;
                    border-radius: .25rem;
                }

                .btn-submit:disabled {
                    background-color: #cccccc;
                }
            </style>
            <script>
                <?php if (isset($_SESSION['error_message'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: '<?php echo $_SESSION['error_message']; ?>',
                        confirmButtonText: 'OK'
                    });
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
            </script>
            <style>
                .swal2-popup {
                    font-size: 0.9rem !important;
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