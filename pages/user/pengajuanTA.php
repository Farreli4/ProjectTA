<?php
session_start();
$nama_mahasiswa = $_SESSION['username'] ?? 'farel';

try {
  $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Get student info
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
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Function to get document status
function getDocumentStatus($nama_mahasiswa, $document_type)
{
  try {
    $conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $columnMap = [
      'Form Pendaftaran dan Persetujuan Tema' => 'form_pendaftaran_persetujuan_tema(TA)',
      'Bukti Pembayaran' => 'bukti_pembayaran(TA)',
      'Bukti Transkrip Nilai' => 'bukti_transkip_nilai(TA)',
      'Bukti Lulus Mata kuliah Magang / PI' => 'bukti_kelulusan_magang(TA)',
    ];

    $column = $columnMap[$document_type];

    $sql = "SELECT `$column` FROM mahasiswa WHERE username = :nama";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':nama' => $nama_mahasiswa]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result && $result[$column] !== null ? 'Menunggu Verifikasi' : 'Belum Upload';
  } catch (PDOException $e) {
    return 'Error';
  }
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
              <a class="dropdown-item" href="../../login.php">
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
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengajuan Ujian Tugas Akhir</h4>
                  <p class="card-description">Status Dokumen Pengajuan</p>

                  <div class="status-grid">
                    <?php
                    $documents = [
                      'Form Pendaftaran dan Persetujuan Tema',
                      'Bukti Pembayaran',
                      'Bukti Transkrip Nilai',
                      'Bukti Lulus Mata kuliah Magang / PI',
                    ];

                    foreach ($documents as $doc) {
                      $status = getDocumentStatus($nama_mahasiswa, $doc);
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
                    <form method="post">
                      <button type="submit" name="submit_pengajuan" class="btn-submit">
                        Submit Pengajuan
                      </button>
                    </form>
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