<?php
// Sesuaikan path dengan lokasi file koneksi
include '../../config/connection.php';

session_start();
$nama_dosen = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $check = "SELECT nip, nama_dosen, prodi FROM dosen_pembimbing WHERE username = :nama";
    $checkNip = $conn->prepare($check);
    $checkNip->execute([':nama' => $nama_dosen]);
    $row = $checkNip->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nip = $row['nip'];
        $nama_dosen = $row['nama_dosen'];
        $prodi = $row['prodi'];
    } else {
        $nip = '2676478762574';
        $nama_dosen = 'Nama Default';
        $prodi = 'PRODI';
    }
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dosen Pembimbing</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../Template/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../Template/skydash/js/select.dataTables.min.css">
    <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
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
                

                <!--NAVBAR KANAN-->
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>

                        <!-- NOTIFIKASI -->
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
                    <!-- Profile Dropdown -->
                    <ul class="navbar-nav navbar-nav-right">
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
                                        <p class="font-weight-bold mb-1"><?php echo htmlspecialchars($nama_dosen); ?></p>
                                        <p class="text-muted mb-1"><?php echo htmlspecialchars($nip); ?></p>
                                        <p class="text-muted mb-1"><?php echo htmlspecialchars($prodi); ?></p>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../../index.php">
                                        <i class="ti-power-off text-primary"></i>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
            </div>
        </nav>

        <!-- Page Body Wrapper -->
        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alurpanduan.php">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">Alur Panduan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Dokumen Persyaratan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="dokumenSempro.php">Seminar Proposal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="dokumenUjian.php">Ujian Akhir</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daftarmahasiswa.php">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Daftar Mahasiswa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">
                            <i class="ti-power-off menu-icon"></i>
                            <span class="menu-title">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Panel -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Daftar Mahasiswa</h4>
                                        <p class="card-description">
                                            Tabel <code>Data Mahasiswa Bimbingan</code>
                                        </p>
                                        <div class="table-responsive">
                                            <?php
                                            try {
                                                $conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');

                                                // Check dosen
                                                $check_dosen_sql = "SELECT id_dosen FROM dosen_pembimbing WHERE nama_dosen=?";
                                                $stmt_check_dosen = $conn->prepare($check_dosen_sql);
                                                if (!$stmt_check_dosen) {
                                                    throw new Exception("Error preparing dosen check query: " . $conn->error);
                                                }

                                                $stmt_check_dosen->bind_param("s", $nama_dosen);
                                                $stmt_check_dosen->execute();
                                                $stmt_check_dosen->store_result();

                                                if ($stmt_check_dosen->num_rows == 0) {
                                                    echo "<div class='alert alert-warning'>Dosen tidak ditemukan.</div>";
                                                    exit;
                                                }

                                                $stmt_check_dosen->bind_result($id_dosen);
                                                $stmt_check_dosen->fetch();
                                                $stmt_check_dosen->close();

                                                // Check mahasiswa
                                                $sql_im = "SELECT id_mahasiswa FROM mahasiswa_dosen WHERE id_dosen=?";
                                                $stmt_im = $conn->prepare($sql_im);
                                                if (!$stmt_im) {
                                                    throw new Exception("Error preparing mahasiswa query: " . $conn->error);
                                                }

                                                $stmt_im->bind_param("i", $id_dosen);
                                                $stmt_im->execute();
                                                $result_im = $stmt_im->get_result();

                                                if ($result_im->num_rows == 0) {
                                                    echo "<div class='alert alert-info'>Tidak ada mahasiswa yang dibimbing.</div>";
                                                    exit;
                                                }

                                                // If we have students, show the table
                                                echo '<table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama</th>
                                                            <th>Nim</th>
                                                            <th>Prodi</th>
                                                            <th>Kelas</th>
                                                            <th>No Telepon</th>
                                                            <th>Tema</th>
                                                            <th>Judul</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                $id_mahasiswa_list = [];
                                                while ($row = $result_im->fetch_assoc()) {
                                                    $id_mahasiswa_list[] = $row['id_mahasiswa'];
                                                }

                                                $id_mahasiswa_placeholder = str_repeat('?,', count($id_mahasiswa_list) - 1) . '?';
                                                $sql1 = "SELECT id_mahasiswa, nama_mahasiswa, nim, prodi, kelas, nomor_telepon, tema, judul 
                                                        FROM mahasiswa 
                                                        WHERE id_mahasiswa IN ($id_mahasiswa_placeholder)";

                                                $stmt1 = $conn->prepare($sql1);
                                                if (!$stmt1) {
                                                    throw new Exception("Error preparing mahasiswa detail query: " . $conn->error);
                                                }

                                                $stmt1->bind_param(str_repeat('i', count($id_mahasiswa_list)), ...$id_mahasiswa_list);
                                                $stmt1->execute();
                                                $result = $stmt1->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row['id_mahasiswa']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['prodi']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nomor_telepon']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['tema']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                                                    echo "</tr>";
                                                }

                                                echo '</tbody></table>';
                                            } catch (Exception $e) {
                                                echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
                                            } finally {
                                                if (isset($conn)) {
                                                    $conn->close();
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Copyright © 2025.
                            <a href="https://nestpoliteknik.com/" target="_blank">Politeknik Nest Sukoharjo</a>.
                            All rights reserved.
                        </span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                            <a href="https://wa.me/628112951003" target="_blank">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="20" height="20" class="me-2">
                                +6281 1295 1003
                            </a>
                        </span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Distributed by <a href="https://www.themewagon.com/" target="_blank">Anak Magang UNS</a>
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../Template/skydash/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../Template/skydash/vendors/chart.js/Chart.min.js"></script>
    <script src="../../Template/skydash/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../../Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../../Template/skydash/js/dataTables.select.min.js"></script>
    <script src="../../Template/skydash/js/off-canvas.js"></script>
    <script