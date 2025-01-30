<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Panduan</title>
  <!-- plugins:css -->
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
  <!-- endinject -->
  <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="../../assets/css/css/user/dashboard.css">
  <style>
    .card-backgroun {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://www.seekpng.com/png/detail/310-3105135_literacy-arrow-up-icon-png.png');
      background-repeat: no-repeat;
      background-size: 120% 100%;
      background-position: center;
      z-index: 1;
    }

    .card-backgroun:after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(36, 53, 69, 0.57);
      z-index: 2;
    }

    .link {
      text-decoration: none;
      color: inherit;
      transition: color 0.3s ease;
    }

    .link:hover,
    .link:focus,
    .link:active {
      text-decoration: none;
      color: aquamarine;

    
    }

    /* Base card styles */
.card {
  position: relative;
  border-radius: 15px;
  overflow: hidden;
  transition: transform 0.2s;
  min-height: 110px;
  margin-bottom: 1rem;
}

.card:hover {
  transform: translateY(-5px);
}

/* Card variants */
.card-tale {
  background: #4747A1;
}

.card-dark-blue {
  background: #2196F3;
}

.card-light-blue {
  background: #4B49AC;
}

.card-light-danger {
  background: #F3797E;
}

/* Card body */
.card-body {
  position: relative;
  z-index: 3;
  padding: 1.25rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.card-body span {
  font-weight: 500;
  color: #fff;
}

.card-body i {
  color: #fff;
}

/* Background image styles */
.card-background {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('https://www.seekpng.com/png/detail/310-3105135_literacy-arrow-up-icon-png.png');
  background-repeat: no-repeat;
  background-size: 120% 100%;
  background-position: center;
  opacity: 0.1;
  z-index: 1;
}

.card-background:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(36, 53, 69, 0.57);
  z-index: 2;
}

.card-background1 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('../../img/alur.png');
  background-repeat: no-repeat;
  background-size: contain;
  background-position: left;
  opacity: 0.1;
  z-index: 1;
}

.card-background1:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(115, 38, 38, 0);
  z-index: 2;
}

.card-background2 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('../../img/student.png');
  background-repeat: no-repeat;
  background-size: 40%;
  background-position: left;
  opacity: 0.1;
  z-index: 1;
}

.card-background2:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(115, 38, 38, 0);
  z-index: 2;
}

/* Section styles */
.section-title {
  color: #333;
  padding-bottom: 0.5rem;
  margin-bottom: 1rem;
  border-bottom: 1px solid #eee;
}

/* Link styles */
.link {
  text-decoration: none;
  color: inherit;
  display: block;
  height: 100%;
}

.link:hover,
.link:focus,
.link:active {
  text-decoration: none;
  color: aquamarine;
}

/* Layout */
.main-card {
  height: calc(100% - 1rem);
}

.result-box {
  height: 120px;
}

/* Grid adjustments */
.upload-section .col-md-3 {
  width: 20%;
  padding: 0 0.5rem;
}

.submission-section .col-md-3 {
  width: 25%;
  padding: 0 0.5rem;
}

/* Mobile styles */
@media (max-width: 768px) {
  .card {
    min-height: 100px;
  }
  
  .upload-section .col-md-3,
  .submission-section .col-md-3 {
    width: 100%;
    padding: 0 1rem;
  }
  
  .result-box {
    height: auto;
  }
  
  .card-tale {
    height: 150px;
  }
  
  .card-background {
    background-size: 100% auto;
  }
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
                <li class="nav-item"> <a class="nav-link" href="uploadSeminar.php">Upload Seminar</a></li>
                <li class="nav-item"> <a class="nav-link" href="uploadBeritaAcara.php">Upload Berita Acara</a></li>
                <li class="nav-item"> <a class="nav-link" href="uploadUjian.php">Upload Ujian</a></li>
                <li class="nav-item"> <a class="nav-link" href="uploadNilai.php">Upload Nilai</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
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
              <i class="icon-columns menu-icon"></i>
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
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome Aa</h3>
                  <h6 class="font-weight-normal mb-0">Website Pengumpulan Tugas Akhir <span class="text-primary">Politeknik NEST Sukoharjp</span></h6>
                </div>
              </div>
            </div>
          </div>


  <!-- Main Dashboard Content -->
  <div class="row">
    <!-- Guidelines Box (Left Side) -->
    <div class="col-lg-3 mb-4">
      <a href="panduan.php" class="text-decoration-none">
        <div class="card card-tale h-100">
          <div class="card-background"></div>
          <div class="card-body d-flex align-items-center">
            <i class="icon-paper menu-icon me-3"></i>
            <span class="text-white">Alur & Panduan</span>
          </div>
        </div>
      </a>
    </div>

    <!-- Right Side Content -->
    <div class="col-lg-9">
      <!-- Results Section -->
      <div class="row mb-4">
        <!-- Hasil Nilai Box -->
        <div class="col-md-6 mb-3">
          <a href="hasilNilai.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Hasil Nilai</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Lampiran Box -->
        <div class="col-md-6 mb-3">
          <a href="lampiran.php" class="text-decoration-none">
            <div class="card card-light-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Lampiran</span>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Upload Section -->
      <div class="row mb-4">
        <div class="col-12">
          <h5 class="section-title">Upload</h5>
        </div>
        <!-- Upload TA Box -->
        <div class="col upload-box">
          <a href="uploadTA.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Upload TA</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Upload Seminar Box -->
        <div class="col upload-box">
          <a href="uploadSeminar.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Upload Seminar</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Upload Berita Acara Box -->
        <div class="col upload-box">
          <a href="uploadBeritaAcara.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Upload Berita Acara</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Upload Ujian Box -->
        <div class="col upload-box">
          <a href="uploadUjian.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Upload Ujian</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Upload Nilai Box -->
        <div class="col upload-box">
          <a href="uploadNilai.php" class="text-decoration-none">
            <div class="card card-dark-blue">
              <div class="card-background1"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-layout menu-icon me-3"></i>
                <span class="text-white">Upload Nilai</span>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Pengajuan Section -->
      <div class="row">
        <div class="col-12">
          <h5 class="section-title">Pengajuan</h5>
        </div>
        <!-- Pengajuan TA Box -->
        <div class="col-md-3 mb-3">
          <a href="pengajuanTA.php" class="text-decoration-none">
            <div class="card card-light-danger">
              <div class="card-background2"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-columns menu-icon me-3"></i>
                <span class="text-white">Pengajuan TA</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Pengajuan Seminar Box -->
        <div class="col-md-3 mb-3">
          <a href="pengajuanSeminar.php" class="text-decoration-none">
            <div class="card card-light-danger">
              <div class="card-background2"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-columns menu-icon me-3"></i>
                <span class="text-white">Pengajuan Seminar</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Pengajuan Ujian Box -->
        <div class="col-md-3 mb-3">
          <a href="pengajuanUjian.php" class="text-decoration-none">
            <div class="card card-light-danger">
              <div class="card-background2"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-columns menu-icon me-3"></i>
                <span class="text-white">Pengajuan Ujian</span>
              </div>
            </div>
          </a>
        </div>
        <!-- Pengajuan Nilai Box -->
        <div class="col-md-3 mb-3">
          <a href="pengajuanNilai.php" class="text-decoration-none">
            <div class="card card-light-danger">
              <div class="card-background2"></div>
              <div class="card-body d-flex align-items-center">
                <i class="icon-columns menu-icon me-3"></i>
                <span class="text-white">Pengajuan Nilai</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer" style="display: flex;">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block" style="text-align: center; justify-content: center;">Copyright © 2023. <a href="https://www.bootstrapdash.com/" target="_blank">Politeknik NEST</a> Teknologi Informasi</span>
            </div>
          </footer>
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