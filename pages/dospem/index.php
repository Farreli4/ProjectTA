<?php
include '../../config/connection.php';
session_start();
$nama_dosen = $_SESSION['username'];

$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$check = "SELECT nip, nama_dosen, prodi FROM dosen_pembimbing WHERE username = :nama";
$checkNip = $conn2->prepare($check);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard Dosen Pembimbing</title>
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
  <!-- endinject -->
  <link rel="shortcut icon" href="../../assets/img/Logo.webp" />

  <link rel="stylesheet" type="text/css" href="../../assets/css/css/dospem/dospem.css">
  <link rel="stylesheet" href="../../assets/css/css/dospem/dospem.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <style>
    .card-backgroun {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('../../assets/img/guide.png');
      background-repeat: no-repeat;
      background-size: 50%;
      background-position: left;
      z-index: 1;
    }

    .card-backgroun:after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(115, 38, 38, 0);
      /* Warna dark blue dengan opacity */
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
                  <p class="font-weight-bold mb-1"><?php echo htmlspecialchars($nama_dosen); ?></p>
                  <p class="text-muted mb-1"><?php echo htmlspecialchars($nip); ?></p>
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
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>



          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="../../Template/skydash/images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="../../Template/skydash/images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="../../Template/skydash/images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>

            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
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
            <a class="nav-link"
              data-toggle="collapse" href="javascript:void(0);" data-target="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
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

      <!-- MAIN-->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome <span class="text-primary"><?php echo htmlspecialchars($nama_dosen); ?></span> </h3>
                  <h6>NIP : <span class="text-primary"><?php echo htmlspecialchars($nip); ?></span> </h6><br>
                  <h4 class="font-weight-normal mb-0">Website Sistem Informasi <span class="text-primary">Politeknik Nest Sukoharjo</span></h4>
                </div>
              </div>
            </div>
          </div>
          <!--BOX-->
          <div class="col-md-8 grid-margin transparent">
            <div class="row">
              <!-- First row -->
              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                  <a href="alurpanduan.php" class="link">
                    <div class="card-backgroun"></div>
                    <div class="card-body" style="display: flex;">
                      <i class=" menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Alur dan Panduan</span>
                    </div>
                </div>
                </a>
              </div>
              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                  <a href="dokumenSempro.php" class="link">
                    <div class="card-background1"></div>
                    <div class="card-body" style="display: flex;">
                      <i class=" menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Dokumen Seminar Proposal</span>
                    </div>
                </div>
                </a>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-tale">
                  <a href="dokumenUjian.php" class="link">
                    <div class="card-background1"></div>
                    <div class="card-body" style="display: flex;">
                      <i class=" menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0; ">Dokumen Ujian</span>
                    </div>
                </div>
                </a>
              </div>

              <!-- Second row -->
              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                  <a href="daftarmahasiswa.php" class="link">
                    <div class="card-background2"></div>
                    <div class="card-body" style="display: flex;">
                      <i class=" menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:50px; margin-top: 0;">Daftar Mahasiswa</span>
                    </div>
                </div>
                </a>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                  <a href="../../index.php" class="link">
                    <div class="card-background3"></div>
                    <div class="card-body" style="display: flex;">
                      <i class=" menu-icon" style="margin-right: 10px;"></i>
                      <span class="mb-4" style="margin-left:70px; margin-top: 0;">Logout</span> </span>
                    </div>
                </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- content ends -->

        <!-- partial:partials/_footer.html -->
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
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Anak Magang UNS</a></span>
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
  <script src="../../Template/skydash/s/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>