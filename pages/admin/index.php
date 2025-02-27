<?php
session_start();
$nama_admin = $_SESSION['username'];

include '../../config/connection.php';
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard Admin</title>
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
  <link rel="shortcut icon" href="../../assets/img/Logo.webp" />

  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/dashboard.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/dashboard.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <?php
    include "bar.php";
    ?>
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

          <?php

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT status_ujian, COUNT(*) as count FROM ujian
                          WHERE status_ujian IN ('dijadwalkan', 'selesai') 	
                          GROUP BY status_ujian";
          $result = $conn->query($sql);

          $xValues = [];
          $yValues = [];

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $xValues[] = $row['status_ujian'];
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