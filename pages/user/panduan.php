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
  <style>
    .zoomable {
      cursor: pointer;
      border-radius: 20px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      max-width: 80%;
      max-height: 80%;
      border-radius: 15px;
      border-top-right-radius: 25px;
    }

    .close {
      position: absolute;
      top: 20px;
      right: 30px;
      color: white;
      font-size: 30px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
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
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Alur dan Panduan</h3>
                  <h6 class="font-weight-normal mb-0">Alur dan Panduan Pengajuan Tugas Akhir, Seminar Proposal, dan Ujian</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="main-panel">
            <div class="content-wrapper">

              <!-- Flow Diagrams Section -->
              <div class="row">
                <div class="col-md-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title mb-4">Diagram Alur Pengajuan</h4>
                      <div class="flow-container">
                        <div class="image-section" onclick="openModal()">
                          <img src="../../assets/img/alur4.png" class="img-fluid zoomable" alt="Alur 1">
                        </div>
                        <div class="text-center text-muted mt-3">
                          <small><i class="fa fa-search-plus"></i> Klik gambar untuk memperbesar</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Download Section -->
              <div class="row">
                <div class="col-md-12 grid-margin">
                  <div class="card bg-light">
                    <div class="card-body">
                      <div class="text-center">
                        <h5 class="mb-4">Dokumen Panduan Lengkap</h5>
                        <a href="https://drive.google.com/your-drive-link-here" class="btn btn-primary btn-lg" target="_blank">
                          <i class="fa fa-download me-2"></i> Download Panduan Penggunaan Sistem
                        </a>
                        <p class="text-muted mt-3">Format PDF - Klik untuk mengunduh panduan lengkap</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div id="imageModal" class="modal" onclick="closeModal()">
                <span class="close">&times;</span>
                <img class="modal-content" id="modalImg">
              </div>

              <!-- Additional Information -->
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Informasi Penting</h5>
                      <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        Pastikan Anda membaca panduan dengan seksama sebelum melakukan pengajuan.
                      </div>
                      <div class="row mt-4">
                        <div class="col-md-6">
                          <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-check-circle text-success me-3"></i>
                            <span>Persiapkan semua dokumen yang diperlukan</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-clock text-warning me-3"></i>
                            <span>Perhatikan jadwal dan tenggat waktu pengajuan</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-file-alt text-primary me-3"></i>
                            <span>Lengkapi formulir dengan data yang valid</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="d-flex align-items-center mb-3">
                            <i class="fa fa-users text-info me-3"></i>
                            <span>Konsultasikan dengan dosen pembimbing</span>
                          </div>
                        </div>
                      </div>
                    </div>
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
    <script>
      function openModal() {
        let modal = document.getElementById("imageModal");
        let modalImg = document.getElementById("modalImg");
        let img = document.querySelector(".zoomable");
        modal.style.display = "flex";
        modalImg.src = img.src;
      }

      function closeModal() {
        document.getElementById("imageModal").style.display = "none";
      }
    </script>


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