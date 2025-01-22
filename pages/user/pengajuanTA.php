

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
                        <a class="nav-link" href="panduan.html">
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
                                <li class="nav-item"> <a class="nav-link" href="uploadSeminar.php">Upload Sempro</a></li>
                                <li class="nav-item"> <a class="nav-link" href="uploadUjian.php">Upload Ujian</a></li>
                                <li class="nav-item"> <a class="nav-link" href="lampiran.php">Lampiran</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" href="pengajuanTA.php">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan TA</span>
                        </a>
                    </li>
                    <li class="nav-item" href="pengajuanSeminar.php">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan Sempro</span>
                        </a>
                    </li>
                    <li class="nav-item" href="pengajuanUjian.php">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Pengajuan Ujian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
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
                    <div class="container">
                    <h3>Pendaftaran Tugas Akhir</h3>
        <div class="document-grid">
            <!-- Form Pendaftaran -->
            <div class="document-card">
                <div class="document-title">Form Pendaftaran dan Persetujuan Tema</div>
                <div class="status-badge status-terverifikasi">Terverifikasi</div>
                <div class="document-info">
                    <strong>Diupload:</strong> 20 Jan 2024<br>
                    <strong>Diverifikasi:</strong> 21 Jan 2024
                </div>
            </div>

            <!-- Jurnal Magang -->
            <div class="document-card">
                <div class="document-title">Bukti Pembayaran</div>
                <div class="status-badge status-terverifikasi">Terverifikasi</div>
                <div class="document-info">
                    <strong>Diupload:</strong> 20 Jan 2024<br>
                    <strong>Diverifikasi:</strong> 29 Jan 2024
                </div>
            </div>

            <!-- Nilai Magang -->
            <div class="document-card">
                <div class="document-title">Bukti Transkrip Nilai</div>
                <div class="status-badge status-menunggu">Menunggu Verifikasi</div>
                <div class="document-info">
                    <strong>Diupload:</strong> 21 Jan 2024
                </div>
            </div>


            <!-- Laporan Magang -->
            <div class="document-card">
                <div class="document-title">Bukti Lulus Mata kuliah Magang / PI</div>
                <div class="status-badge status-menunggu">Menunggu Verifikasi</div>
                <div class="document-info">
                    <strong>Diupload:</strong> 21 Jan 2024
                </div>
            </div>
        </div>
        <div class="status-header">
            <h1 class="header-title">Status Dokumen Pengajuan</h1>
            <button class="submission-button" onclick="showNotification()">Pengajuan Tugas Akhir</button>
        </div>

    </div>

    <div id="notification" class="notification">
        Pengajuan berhasil dikirim! Menunggu verifikasi admin.
    </div>

    <script>
        function showNotification() {
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
    </script>
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
        <script src="../../Template/skydash/skydash/vendors/js/vendor.bundle.base.js"></script>
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
        <script src="../../Template/skydash/js/template.js"></script>
        <script src="../../Template/skydash/js/settings.js"></script>
        <script src="../../Template/skydash/js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="../../Template/skydash/js/dashboard.js"></script>
        <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
        <!-- End custom js for this page-->
</body>

</html>