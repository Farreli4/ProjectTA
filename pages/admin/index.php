<?php include '../../config/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />

  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/dashboard.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/dashboard.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php"><img src="../../assets/img/logo2.png" class="mr-2" alt="" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../../assets/img/Logo.webp" alt="" /></a>
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
        <ul class="navbar-nav navbar-nav-right">
          <!-- Notification Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count" id="notificationCount"></span> <!-- Notification count here -->
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <div id="notifications">
                <script>
                  function fetchNotifications() {
                    $.ajax({
                      url: 'fetch_notif.php',
                      method: 'GET',
                      success: function(data) {
                        const notifications = JSON.parse(data);
                        const notificationCount = $('#notificationCount');
                        const notificationList = $('#notifications');

                        notificationCount.text(notifications.length);

                        notificationList.empty();

                        if (notifications.length === 0) {
                          notificationList.append(`
                                          <a class="dropdown-item preview-item">
                                              <div class="preview-item-content">
                                                  <h6 class="preview-subject font-weight-normal">No new notifications</h6>
                                              </div>
                                          </a>
                                      `);
                        } else {
                          notifications.forEach(function(notification) {
                            const notificationItem = `
                                              <a class="dropdown-item preview-item">
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

                  $(document).ready(function() {
                    fetchNotifications();
                    setInterval(fetchNotifications, 30000);
                  });
                </script>
              </div>
            </div>
          </li>

          <!-- Profile Dropdown -->
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="../../Template/skydash/images/faces/face28.jpg" alt="profile" />
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" href="../../index.php">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>

          <!-- Additional Settings Option (if any) -->
          <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
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
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 font-weight-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary mr-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary mr-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
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
              <li class="list">
                <div class="profile"><img src="../../Template/skydash/images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="../../Template/skydash/images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="../../Template/skydash/images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
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
            <a class="nav-link" href="daftarDosen.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Daftar Dosen</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="daftarMahasiswa.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Daftar Mahasiswa</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Pendaftaran</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pendaftaranTA.php">Tugas Akhir</a></li>
                <li class="nav-item"> <a class="nav-link" href="pendaftaranSeminar.php">Seminar</a></li>
                <li class="nav-item"> <a class="nav-link" href="pendaftaranUjian.php">Ujian</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Dokumen</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="dokumenTA.php">Tugas Akhir</a></li>
                <li class="nav-item"> <a class="nav-link" href="dokumenSeminar.php">Seminar</a></li>
                <li class="nav-item"> <a class="nav-link" href="dokumenUjian.php">Ujian</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Log Out</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Selamat Datang di Politeknik NEST</h3>
                </div>
              </div>
            </div>
          </div>

          <?php
          // Koneksi ke database
          $conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");
          if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
          }

          // Ambil total pendaftar tugas akhir
          $sqlTA = "SELECT COUNT(*) AS total FROM tugas_akhir";
          $resultTA = $conn->query($sqlTA);
          $totalTA = ($resultTA->num_rows > 0) ? $resultTA->fetch_assoc()['total'] : 0;

          // Ambil total pendaftar seminar
          $sqlSeminar = "SELECT COUNT(*) AS total FROM seminar_proposal";
          $resultSeminar = $conn->query($sqlSeminar);
          $totalSeminar = ($resultSeminar->num_rows > 0) ? $resultSeminar->fetch_assoc()['total'] : 0;

          // Ambil total pendaftar ujian
          $sqlUjian = "SELECT COUNT(*) AS total FROM ujian";
          $resultUjian = $conn->query($sqlUjian);
          $totalUjian = ($resultUjian->num_rows > 0) ? $resultUjian->fetch_assoc()['total'] : 0;

          $conn->close();
          ?>

          <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
              <a href="pendaftaranTA.php">
                <div class="card card-dark-blue">
                  <div class="card-body text-center">
                    <p class="mb-4">Total Pendaftar Tugas Akhir</p>
                    <p class="fs-30 mb-2"><?php echo number_format($totalTA); ?></p>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
              <a href="pendaftaranSeminar.php">
                <div class="card card-dark-blue">
                  <div class="card-body text-center">
                    <p class="mb-4">Total Pendaftar Seminar</p>
                    <p class="fs-30 mb-2"><?php echo number_format($totalSeminar); ?></p>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 mb-4">
              <a href="pendaftaranUjian.php">
                <div class="card card-light-blue">
                  <div class="card-body text-center">
                    <p class="mb-4">Total Pendaftar Ujian</p>
                    <p class="fs-30 mb-2"><?php echo number_format($totalUjian); ?></p>
                  </div>
                </div>
              </a>
            </div>
          </div>


          <div class="row">
            <!-- Chart 1 -->
            <div class="col-md-4">
              <canvas id="myChart2"></canvas>
            </div>
            <!-- Chart 2 -->
            <div class="col-md-4">
              <canvas id="myChart3"></canvas>
            </div>
            <!-- Chart 3 -->
            <div class="col-md-4">
              <canvas id="myChart4"></canvas>
            </div>
          </div>
          <?php
          $conn->connect("127.0.0.1", "root", "", "sistem_ta");

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT status_pengajuan, COUNT(*) as count FROM tugas_akhir
                          WHERE status_pengajuan IN ('Disetujui', 'Revisi', 'Ditolak') 	
                          GROUP BY status_pengajuan";
          $result = $conn->query($sql);

          $xValues = [];
          $yValues = [];

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $xValues[] = $row['status_pengajuan'];
              $yValues[] = $row['count'];
            }
          }
          $conn->close();
          ?>
          <canvas id="myChart2"></canvas>
          <script>
            var xValues = <?php echo json_encode($xValues); ?>;
            var yValues = <?php echo json_encode($yValues); ?>;

            var barColors = ["#73ad91", "#ebd382", "#d25d5d", ];

            new Chart("myChart2", {
              type: "doughnut",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                title: {
                  display: true,
                  text: "Jumlah Pendaftar Tugas Akhir"
                }
              }
            });
          </script>

          <?php
          $conn->connect("127.0.0.1", "root", "", "sistem_ta");

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT status_seminar, COUNT(*) as count FROM seminar_proposal
                          WHERE status_seminar IN ('dijadwalkan', 'ditunda', 'selesai')
                          GROUP BY status_seminar";
          $result = $conn->query($sql);

          $xValues = [];
          $yValues = [];

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $xValues[] = $row['status_seminar'];
              $yValues[] = $row['count'];
            }
          }
          $conn->close();
          ?>
          <canvas id="myChart4"></canvas>
          <script>
            var xValues = <?php echo json_encode($xValues); ?>;
            var yValues = <?php echo json_encode($yValues); ?>;

            var barColors = ["#73ad91", "#ebd382", "#d25d5d", ];

            new Chart("myChart4", {
              type: "doughnut",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                title: {
                  display: true,
                  text: "Jumlah Pendaftar Ujian"
                }
              }
            });
          </script>

          <?php
          $conn->connect("127.0.0.1", "root", "", "sistem_ta");

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT status_pengajuan, COUNT(*) as count FROM tugas_akhir
                          WHERE status_pengajuan IN ('Disetujui', 'Revisi', 'Ditolak') 	
                          GROUP BY status_pengajuan";
          $result = $conn->query($sql);

          $xValues = [];
          $yValues = [];

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $xValues[] = $row['status_pengajuan'];
              $yValues[] = $row['count'];
            }
          }
          $conn->close();
          ?>
          <canvas id="myChart3"></canvas>
          <script>
            var xValues = <?php echo json_encode($xValues); ?>;
            var yValues = <?php echo json_encode($yValues); ?>;

            var barColors = ["#73ad91", "#ebd382", "#d25d5d", ];

            new Chart("myChart3", {
              type: "doughnut",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                title: {
                  display: true,
                  text: "Jumlah Pendaftar Seminar"
                }
              }
            });
          </script>
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
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://politekniknest.ac.id/" target="_blank">Anak Magang UNS</a></span>
            </div>
          </footer>
          <!-- partial -->


        </div>
      </div>
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
  <script src="../../Template/skydash/js/Template.js"></script>
  <script src="../../Template/skydash/js/settings.js"></script>
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>