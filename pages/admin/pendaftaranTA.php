<?php
session_start();
$nama_admin = $_SESSION['username'];
include "../../config/connection.php";
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$check = "SELECT nomor_telepon, nama_admin FROM admin WHERE username = :nama";
$checkNomer_telepon = $conn2->prepare($check);
$checkNomer_telepon->execute([':nama' => $nama_admin]);
$row = $checkNomer_telepon->fetch(PDO::FETCH_ASSOC);

if ($row) {
  $nomor_telepon = $row['nomor_telepon'];
  $nama_admin= $row['nama_admin'];
  
} else {
  $nomor_telepon = '0857364562';
  $nama_admin = 'Nama Default';
  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pendaftaran Tugas Akhir</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- plugins:css -->
  <link rel="stylesheet" href="../../Template/skydash/vendors/feather/feather.css">
  <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../Template/skydash/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../assets/img/Logo.webp" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/mahasiswa.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=folder_open" />
  <style>
    #nonclick{
      pointer-events: none;
    }
    
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php"><img src="../../assets/img/logo2.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../../assets/img/Logo.webp" alt="logo"/></a>
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
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count" id="notificationCount"></span> 
              <!-- Notification count here -->
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
                  data: { id: notificationId },
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
                  <p class="font-weight-bold mb-1"><?php echo htmlspecialchars($nama_admin); ?></p>
                  <p class="text-muted mb-1"><?php echo htmlspecialchars($nomor_telepon); ?></p>
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
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
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
      <?php 
        $current_page = basename($_SERVER['PHP_SELF']); 
      ?>
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'daftarDosen.php') ? 'active' : ''; ?>" href="daftarDosen.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Daftar Dosen</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'daftarMahasiswa.php') ? 'active' : ''; ?>" href="daftarMahasiswa.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Daftar Mahasiswa</span>
            </a>
          </li>

          <!-- Pendaftaran Dropdown -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" 
              aria-expanded="<?= in_array($current_page, ['pendaftaranTA.php', 'pendaftaranSeminar.php', 'pendaftaranUjian.php']) ? 'true' : 'false'; ?>" 
              aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Pendaftaran</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?= in_array($current_page, ['pendaftaranTA.php', 'pendaftaranSeminar.php', 'pendaftaranUjian.php']) ? 'show' : ''; ?>" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'pendaftaranTA.php') ? 'active' : ''; ?>" href="pendaftaranTA.php">Tugas Akhir</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'pendaftaranSeminar.php') ? 'active' : ''; ?>" href="pendaftaranSeminar.php">Seminar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'pendaftaranUjian.php') ? 'active' : ''; ?>" href="pendaftaranUjian.php">Ujian</a>
                </li>
              </ul>
            </div>
          </li>

          <!-- Dokumen Dropdown -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" 
              aria-expanded="<?= in_array($current_page, ['dokumenTA.php', 'dokumenSeminar.php', 'dokumenUjian.php']) ? 'true' : 'false'; ?>" 
              aria-controls="ui-basic2">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Dokumen</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?= in_array($current_page, ['dokumenTA.php', 'dokumenSeminar.php', 'dokumenUjian.php']) ? 'show' : ''; ?>" id="ui-basic2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'dokumenTA.php') ? 'active' : ''; ?>" href="dokumenTA.php">Tugas Akhir</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'dokumenSeminar.php') ? 'active' : ''; ?>" href="dokumenSeminar.php">Seminar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'dokumenUjian.php') ? 'active' : ''; ?>" href="dokumenUjian.php">Ujian</a>
                </li>
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

      <?php
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          // Ambil total pendaftar tugas akhir
          $sqlTA = "SELECT COUNT(*) AS total FROM tugas_akhir";
          $resultTA = $conn->query($sqlTA);
          $totalTA = ($resultTA->num_rows > 0) ? $resultTA->fetch_assoc()['total'] : 0;
      ?>
      
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-md-5 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body text-center">
                      <p class="mb-4">Total Pendaftar Tugas Akhir</p>
                      <p class="fs-30 mb-2"><?php echo number_format($totalTA); ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                <?php

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

                    var barColors = ["#73ad91", "#ebd382", "#d25d5d",];

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
                                text: "Jumlah Pendaftar"
                            }
                        }
                    });
                </script>
            </div>
            </div>
          </div>
          <?php
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          // Fetch all dosen_pembimbing from the dosen_pembimbing table
          $sql_dosen = "SELECT id_dosen, nama_dosen FROM dosen_pembimbing";
          $result_dosen = $conn->query($sql_dosen);

          // Fetch mahasiswa and their related data from the database
          $sql1 = "SELECT mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa, mahasiswa.nim, mahasiswa.prodi, 
                          tugas_akhir.tema, tugas_akhir.judul, tugas_akhir.status_pengajuan, tugas_akhir.alasan_revisi, 
                          mahasiswa_dosen.id_dosen
                  FROM mahasiswa 
                  LEFT JOIN tugas_akhir ON mahasiswa.id_mahasiswa = tugas_akhir.id_mahasiswa
                  LEFT JOIN mahasiswa_dosen ON mahasiswa.id_mahasiswa = mahasiswa_dosen.id_mahasiswa";
          $result = $conn->query($sql1);
          ?>

          <style>
          /* Membuat tabel lebih rapi dan responsif */
          .table-responsive {
              overflow-x: auto;
              width: 100%;
          }

          table {
              border-collapse: collapse;
              width: 100%;
              background: #fff;
              border-radius: 8px;
              overflow: hidden;
          }

          th, td {
              padding: 12px;
              text-align: center;
              border-bottom: 1px solid #ddd;
          }

          th {
              background-color: #4B49AC;
              color: white;
          }

          h4 {
            text-align: center;
          }

          /* Input tanggal */
          input[type="date"] {
              border: 1px solid #ccc;
              padding: 5px;
              border-radius: 5px;
              text-align: center;
              width: 150px;
          }

          /* Dropdown Status */
          select {
                padding: 5px;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                font-weight: bold;
            }
            select option[value="Revisi"] {
                background: yellow;
            }
            select option[value="Ditolak"] {
                background: red;
                color: white;
            }
            select option[value="Disetujui"] {
                background: green;
                color: white;
            }

          /* Styling untuk dropdown Dosen Pembimbing */
          select[name="dosen_pembimbing"] {
              background-color: #007bff !important; /* Biru */
              color: white;
              padding: 5px;
              border-radius: 5px;
              border: none;
              font-weight: bold;
              cursor: pointer;
          }

          /* Saat opsi dalam dropdown dipilih */
          select[name="dosen_pembimbing"] option {
              background-color:rgb(162, 199, 241); /* Biru */
              color: black;
          }


          /* Tombol Update */
          .btn-update {
              background-color:rgb(178, 212, 249);
              color: white;
              padding: 5px 10px;
              border-radius: 5px;
              border: none;
              cursor: pointer;
          }

          .btn-update:hover {
              background-color: #0056b3;
          }

          /* Ikon dokumen */
          .icon-folder {
              font-size: 20px;
              color: #007bff;
              cursor: pointer;
              text-decoration: none;
          }
          /* Style untuk pop-up */
          .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
          }

          .popup-content {
              background: white;
              padding: 20px;
              border-radius: 10px;
              width: 50%;
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
              animation: fadeIn 0.3s ease-in-out;
          }

          /* Animasi */
          @keyframes fadeIn {
              from {
                  opacity: 0;
                  transform: translate(-50%, -60%);
              }
              to {
                  opacity: 1;
                  transform: translate(-50%, -50%);
              }
          }

          .close-btn {
              position: absolute;
              top: 10px;
              right: 15px;
              font-size: 20px;
              cursor: pointer;
              color: #555;
              transition: color 0.2s;
          }

          .close-btn:hover {
              color: red;
          }

          /* Style untuk tabel */
          .popup-table {
              width: 100%;
              border-collapse: collapse;
              margin-top: 10px;
          }

          .popup-table th, .popup-table td {
              padding: 10px;
              text-align: center;
              border-bottom: 1px solid #ddd;
          }

          .popup-table th {
              background-color: #1b4f72;
              color: white;
              font-weight: bold;
          }

          /* Style untuk tombol Verify */
          .verify-btn {
              padding: 6px 12px;
              border: none;
              border-radius: 5px;
              background-color: #007bff;
              color: white;
              cursor: pointer;
              font-size: 14px;
              transition: background 0.2s ease-in-out;
          }

          .verify-btn:hover {
              background-color: #0056b3;
          }

          /* Style untuk teks "No File" */
          .no-file {
              color: red;
              font-weight: bold;
          }     
          
          .card-title{
          text-align: center;
        }
          </style>
          
<div class="row">  
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <p class="card-title">Pendaftar Tugas Akhir Politeknik Nest Sukoharjo</p>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Tema</th>
                                <th>Judul</th>
                                <th>Dosen Pembimbing</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $event = "tugas_akhir";
                            while ($row = $result->fetch_assoc()) {
                                $status_pengajuan = isset($row['status_pengajuan']) ? $row['status_pengajuan'] : '';
                                $selected_dosen = isset($row['id_dosen']) ? $row['id_dosen'] : '';
                                $has_dosen = !empty($selected_dosen) ? 'yes' : 'no';

                                echo "<tr>";
                                echo "<td>" . $row['id_mahasiswa'] . "</td>";
                                echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                                echo "<td>" . $row['nim'] . "</td>";
                                echo "<td>" . $row['prodi'] . "</td>";
                                echo "<td>" . $row['tema'] . "</td>";
                                echo "<td>" . $row['judul'] . "</td>";
                                echo "<td>";

                                echo "<form action='update_pengajuan.php' method='POST'>";

                                echo "<select name='dosen_pembimbing' class='js-example-basic-single w-30' required>";
                                echo "<option value=''>Select Dosen Pembimbing</option>";

                                $result_dosen->data_seek(0);

                                while ($dosen_row = $result_dosen->fetch_assoc()) {
                                    echo "<option value='" . $dosen_row['id_dosen'] . "' " . ($dosen_row['id_dosen'] == $selected_dosen ? 'selected' : '') . ">" . $dosen_row['nama_dosen'] . "</option>";
                                }

                                echo "</select>";
                                echo "</td>";

                                echo "<td>";
                                echo "<select name='status_pengajuan' onchange='toggleRevisiTextbox(this)' required>
                                        <option value='Ditolak' " . ($status_pengajuan == 'Ditolak' ? 'selected' : '') . ">Ditolak</option>
                                        <option value='Revisi' " . ($status_pengajuan == 'Revisi' ? 'selected' : '') . ">Revisi</option>
                                        <option value='Disetujui' " . ($status_pengajuan == 'Disetujui' ? 'selected' : '') . ">Disetujui</option>
                                      </select>

                                      <div class='revisi-textbox' id='revisi-textbox-" . $row['id_mahasiswa'] . "' data-id='" . $row['id_mahasiswa'] . "' style='display: none;'>
                                        <textarea name='alasan_revisi' rows='3' disabled data-was-revisi='" . ($status_pengajuan == 'Revisi' ? 'true' : 'false') . "'>" . 
                                          (isset($row['alasan_revisi']) ? htmlspecialchars($row['alasan_revisi']) : '') . 
                                        "</textarea>
                                      </div>";

                                echo "<p class='small-text' id='revisi-text-" . $row['id_mahasiswa'] . "' style='display:none;'>" . $row['alasan_revisi'] . "</p>";

                                echo "</td>";


                                echo "<input type='hidden' name='id_mahasiswa' value='" . $row['id_mahasiswa'] . "'>";
                                echo "<input type='hidden' name='has_dosen' value='" . $has_dosen . "'>";
                                echo "<td>";
                                echo "<button class='btn btn-inverse-success btn-fw' type='submit'>Update</button>";
                                echo "</td>";
                                echo "</form>";
                                echo "<td><button class='folder-btn' data-event='" . $event . "' data-userid='" . $row['id_mahasiswa'] . "'><span class='material-symbols-outlined'>folder_open</span></button></td>";
                                echo "</tr>";
                            }
                            $result_dosen->close();
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Pop Up Dokumen-->
<div id="popup" class="popup">
          <div class="popup-content">
              <span class="close-btn">&times;</span>
              <h3>Dokumen</h3>
              <div class="table-responsive">
                  <table class="popup-table">
                      <thead>
                          <tr>
                              <th>Keterangan</th>
                              <th>Dokumen</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody id="popup-content">

                      </tbody>
                  </table>
              </div>
          </div>
      </div>



      
<script>
  // Open Modal
  let openBtn = document.getElementById("open");
    if (openBtn) {
        openBtn.onclick = function () {
            document.getElementById("myModal").style.display = "flex";
        };
    }

    // Close Modal
    let closeBtn = document.querySelector(".close");
    if (closeBtn) {
        closeBtn.onclick = function () {
            document.getElementById("myModal").style.display = "none";
        };
    }

          $(document).on("click", ".folder-btn", function () {
          let event = $(this).data("event");
          let userId = $(this).data("userid");

          console.log("Clicked button for event:", event, "User ID:", userId);

          $.ajax({
              url: "fetch_pdfs.php",
              type: "POST",
              data: { event: event, userId: userId },
              success: function (response) {
                  $("#popup-content").html(response);
                  $("#popup").show();
              },
              error: function (xhr, status, error) {
                  console.error("AJAX Error:", error);
              }
          });
      });

      $(document).on("click", ".close-btn", function () {
          $("#popup").hide();
      });
          
      // Pop Up Verifikasi
      $(document).off("click", ".verify-btn").on("click", ".verify-btn", function (e) {
    e.preventDefault(); 

    let userId = $(this).data("userid");
    let event = $(this).data("event");
    let column = $(this).data("column");
    let button = $(this);

    Swal.fire({
        title: "Konfirmasi Verifikasi",
        text: "Apakah Anda yakin ingin memverifikasi dokumen ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Verifikasi!"
    }).then((result) => {
        if (result.isConfirmed) {
            button.prop("disabled", true).text("Verifying...");

            $.post("verify.php", { userId: userId, event: event, column: column }, function (response) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Dokumen telah diverifikasi.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }).fail(function (xhr) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan dalam verifikasi.",
                    icon: "error"
                });
                button.prop("disabled", false).text("Verify");
            });
        }
    });
});


            
function changeColor(selectElement) {
    var selectedValue = selectElement.value;

    if (selectedValue === 'Revisi') {
        selectElement.style.backgroundColor = 'yellow';
    } else if (selectedValue === 'Ditolak') {
        selectElement.style.backgroundColor = 'red';
    } else if (selectedValue === 'Disetujui') {
        selectElement.style.backgroundColor = 'green';
    } else {
        selectElement.style.backgroundColor = 'rgb(174, 215, 242)';
        selectElement.style.color = 'black';
    }
}

function toggleRevisiTextbox(selectElement) {
    var mahasiswaId = selectElement.closest('tr').querySelector('input[name="id_mahasiswa"]').value;
    var revisiTextbox = document.getElementById('revisi-textbox-' + mahasiswaId);
    var revisiText = document.getElementById('revisi-text-' + mahasiswaId);
    var textarea = revisiTextbox ? revisiTextbox.querySelector('textarea') : null;

    if (!revisiTextbox || !textarea || !revisiText) return;

    if (selectElement.value === 'Revisi') {
        revisiTextbox.style.display = 'block';
        textarea.disabled = false;
    } else {
        revisiTextbox.style.display = 'none';
        textarea.disabled = true;
        revisiText.innerText = ''; // Menghapus teks jika bukan revisi
    }
}

// Saat tombol update ditekan, komentar berubah menjadi teks kecil tanpa border
document.querySelectorAll('.btn-inverse-success').forEach(button => {
    button.addEventListener('click', function (event) {
        var form = this.closest('form');
        var revisiTextbox = form.querySelector('.revisi-textbox');
        var textarea = revisiTextbox ? revisiTextbox.querySelector('textarea') : null;
        var revisiText = form.closest('tr').querySelector('.small-text');

        if (textarea && textarea.value.trim() !== '') {
            revisiText.innerText = textarea.value;
            revisiText.style.display = 'block';
            revisiTextbox.style.display = 'none';
        }
    });
});

window.onload = function () {
    document.querySelectorAll('select[name="status_pengajuan"]').forEach(function (select) {
        changeColor(select);
        toggleRevisiTextbox(select);
    });

    document.querySelectorAll('.revisi-textbox').forEach(function (box) {
        var mahasiswaId = box.getAttribute('data-id');
        var revisiText = document.getElementById('revisi-text-' + mahasiswaId);

        if (revisiText && revisiText.innerText.trim() !== '') {
            revisiText.style.display = 'block';
            box.style.display = 'none';  
        }
    });
};

</script>

        <!-- content-wrapper ends -->
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

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../Template/skydash/js/off-canvas.js"></script>
  <script src="../../Template/skydash/js/hoverable-collapse.js"></script>
  <script src="../../Template/skydash/js/../../Template.js"></script>
  <script src="../../Template/skydash/js/settings.js"></script>s
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

