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
  <link rel="stylesheet" href="../../assets/css/css/user/dashboard.css">
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

  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
     <!--NAVBAR KIRI-->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="images/logo.svg" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
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
              <img src="images/faces/face28.jpg" alt="profile"/>
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
          <li class="nav-item" href="pengajuanSeminar">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Pengajuan Seminar</span>
            </a>
          </li>
          <l  i class="nav-item" href="pengajuanUjian.php">
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
          <!--BOX-->
          <div class="row">
            <!-- Large left box -->
            <div class="col-md-3 mb-4 grid-margin transparent">
              <div class="stretch-card transparent h-50">
                <div class="card card-tale" style="height: calc(165% + 1.5rem);">
                <a href="panduan.php" class="link">
                <div class="card-backgroun"></div>
                  <div class="card-body">
                    <i class="icon-paper menu-icon"></i>
                    <span class="mb-5">Alur & Panduan<span/>
                    </div>
                </div>
                </a>
              </div>
            </div>
          
            <!-- Right side boxes -->
            <div class="col-md-8 grid-margin transparent">
              <div class="row">
                <!-- First row -->
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                  <a href="uploadTA.php" class="link">
                  <div class="card-background1"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-layout menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Upload Tugas Akhir</span>
                    </div>
                  </div>
                  </a>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-light-blue">
                  <a href="uploadSeminar.php" class="link"> 
                  <div class="card-background1"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-layout menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Upload Seminar Proposal</span>
                    </div>
                  </div>
                  </a>
                </div>
                
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                  <a href="uploadUjian.php" class="link"> 
                  <div class="card-background1"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-layout menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Upload Ujian</span>
                    </div>
                  </div>
                  </a>
                </div>

                <!-- Second row -->
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-light-danger">
                  <a href="pengajuanTA.php" class="link">
                  <div class="card-background2"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-columns menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0;">Pengajuan Tugas Akhir</span>
                    </div>
                  </div>
                  </a>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-light-blue">
                  <a href="pengajuanSeminar.php" class="link">
                  <div class="card-background2"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-columns menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0;">Pengajuan Seminar Proposal</span>
                    </div>
                  </div>
                  </a>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                  <div class="card card-light-danger">
                  <a href="pengajuanUjian.php" class="link"> 
                  <div class="card-background2"></div>
                    <div class="card-body" style="display: flex;">
                      <i class="icon-columns menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0;">Pengajuan Ujian   </span>
                    </div>
                  </div>
                  </a>
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

 