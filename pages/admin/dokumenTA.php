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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dokumen Tugas Akhir</title>
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

  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/admin/kumpulanstylediadmin.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php
    include "bar.php";
    ?>

<style>
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header tetap berwarna biru */
        th {
            background-color: #1b4f72 !important;
            color: white;
            padding: 12px;
            text-align: center;
        }

        /* Styling untuk isi tabel */
        td {
            background-color: #ffffff;
            color: black;
            padding: 12px;
            text-align: center;
        }

        /* Menghilangkan garis antar kolom */
        th, td {
            border: none !important;
        }

        /* Menambahkan garis hanya antar baris */
        tr {
            border-bottom: 1px solid #ddd;
        }

        /* Menghilangkan garis di baris terakhir agar lebih rapi */
        tr:last-child {
            border-bottom: none;
        }
          </style>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <!--Advanced-->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Daftar Dokumen TA</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table" style="width:100%">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Nama</th>
                              <th>NIM</th>
                              <th>Program Studi</th>
                              <th>Form Pendaftaran</th>
                              <th>Transkrip Nilai </th>
                              <th>Bukti Kelulusan Matakuliah Magang/PI</th>
                            </tr>
                          </thead>
                          <tbody>
                                <?php
                                $conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');
                                $sql1 = "SELECT id_mahasiswa, nama_mahasiswa, nim, prodi, form_pendaftaran_persetujuan_tema_ta, bukti_transkip_nilai_TA, bukti_kelulusan_magang_TA FROM mahasiswa WHERE 1";
                                $result = $conn->query($sql1);

                                while ($row = mysqli_fetch_array($result)) {
                                  echo "<tr>";
                                  echo "<td>" . $row['id_mahasiswa'] . "</td>";
                                  echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                                  echo "<td>" . $row['nim'] . "</td>";
                                  echo "<td>" . $row['prodi'] . "</td>";
                                  if (!empty($row['form_pendaftaran_persetujuan_ta'])) {
                                    echo "<td><a href='download.php?id=" . $row['id_mahasiswa'] . "&column=form_pendaftaran_persetujuan_tema_ta' target='_blank'>Download Form Pendaftaran</a></td>";
                                } else {
                                    echo "<td>No file</td>";
                                }
                            
                                if (!empty($row['bukti_transkip_nilai_TA'])) {
                                    echo "<td><a href='download.php?id=" . $row['id_mahasiswa'] . "&column=bukti_transkip_nilai_TA' target='_blank'>Download Bukti Transkip</a></td>";
                                } else {
                                    echo "<td>No file</td>";
                                }
                            
                                if (!empty($row['bukti_kelulusan_magang_TA'])) {
                                    echo "<td><a href='download.php?id=" . $row['id_mahasiswa'] . "&column=bukti_kelulusan_magang_TA' target='_blank'>Download Sistem Magang</a></td>";
                                } else {
                                    echo "<td>No file</td>";
                                }
                            
                                echo "</tr>";
                              }
                              $conn->close();
                                ?>
                            </tbody>
                      </table>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>

                
              </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <?php
          include '../../pages/footer.php';
        ?>
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
  <script src="../../Template/skydash/js/settings.js"></script>
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

