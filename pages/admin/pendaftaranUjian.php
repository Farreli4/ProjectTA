<?php
session_start();
$nama_admin = $_SESSION['username'];

$conn = new PDO("mysql:host=localhost;dbname=sistem_ta", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$check = "SELECT nomor_telepon, nama_admin FROM admin WHERE username = :nama";
$checkNomer_telepon = $conn->prepare($check);
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

<?php
$currentPage = basename($_SERVER['PHP_SELF']);

if (strpos($currentPage, 'pendaftaranTA.php') !== false) {
  $category = 'tugas_akhir';
} elseif (strpos($currentPage, 'pendaftaranSeminar.php') !== false) {
    $category = 'seminar'; // This is for the seminar page
} elseif (strpos($currentPage, 'pendaftaranUjian.php') !== false) {
    $category = 'ujian'; // This is for the ujian page
} else {
    $category = 'unknown'; // Default or unknown category, in case none match
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pendaftaran Ujian</title>
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
  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/dosen.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/dosen.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=folder_open" />
  <!-- Add jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
     <?php
     include "sidebar.php";
     ?>
      <!-- partial -->
      <?php

          // Ambil total pendaftar tugas akhir
          $sqlUjian = "SELECT COUNT(*) AS total FROM ujian";
          $resultUjian = $conn->query($sqlUjian);
          $totalUjian = ($resultUjian->num_rows > 0) ? $resultUjian->fetch_assoc()['total'] : 0;
      ?>
      
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-md-5 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body text-center">
                      <p class="mb-4">Total Pendaftar Ujian</p>
                      <p class="fs-30 mb-2"><?php echo number_format($totalUjian); ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                
                <?php
                  $conn->connect("127.0.0.1", "root", "", "sistem_ta");

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
          <!--Advanced-->
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

            /* Memastikan input tetap memiliki border */
            input[type="text"] {
                border: 1px solid #ccc; /* Border default */
                padding: 5px;
                border-radius: 5px;
                text-align: center;
                width: 60px; /* Sesuaikan lebar */
            }

            /* Saat input diklik (focus), border tetap terlihat */
            input[type="text"]:focus {
                border: 1px solid #007bff; /* Warna biru saat diklik */
                outline: none; /* Hilangkan outline bawaan browser */
                box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5); /* Efek glow saat aktif */
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

            select option[value="dijadwalkan"] {
                background: yellow;
            }

            select option[value="ditunda"] {
                background: red;
                color: white;
            }

            select option[value="selesai"] {
                background: green;
                color: white;
            }

            /* Tombol Update */
            .btn-update {
                background-color: #007bff;
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                border: none;
                cursor: pointer;
            }

            .btn-update:hover {
                background-color: #0056b3;
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
        </style>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4>Pendaftar Ujian Politeknik Nest Sukoharjo</h4>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th>Jadwal</th>
                                        <th>Verifikasi</th>
                                        <th>Doc</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");
                                  if ($conn->connect_error) {
                                      die("Koneksi gagal: " . $conn->connect_error);
                                  }

                                  $event = "ujian";
                                  $sql = "SELECT mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa, mahasiswa.nim, 
                                          ujian.status_ujian, ujian.nilai, ujian.tanggal_ujian
                                          FROM mahasiswa
                                          INNER JOIN ujian ON mahasiswa.id_mahasiswa = ujian.id_mahasiswa";
                                  $result = $conn->query($sql);

                                  while ($row = $result->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>{$row['id_mahasiswa']}</td>";
                                      echo "<td>{$row['nama_mahasiswa']}</td>";
                                      echo "<td>{$row['nim']}</td>";
                                      echo "<td>
                                              <form action='update_ujian.php' method='POST'>
                                                  <input type='hidden' name='id_mahasiswa' value='{$row['id_mahasiswa']}'>
                                                  <select name='status_ujian'>
                                                      <option value='dijadwalkan' " . ($row['status_ujian'] == 'dijadwalkan' ? 'selected' : '') . ">Dijadwalkan</option>
                                                      <option value='ditunda' " . ($row['status_ujian'] == 'ditunda' ? 'selected' : '') . ">Ditunda</option>
                                                      <option value='selesai' " . ($row['status_ujian'] == 'selesai' ? 'selected' : '') . ">Selesai</option>
                                                  </select>
                                              </td>
                                              <td><input type='text' name='nilai' value='" . ($row['nilai'] ?? '0') . "'></td>
                                              <td><input type='date' name='tanggal_ujian' value='" . $row['tanggal_ujian'] . "'></td>
                                              <td><button class='btn-update' type='submit'>Verifikasi</button></form></td>
                                              <td><button class='folder-btn' data-event='{$event}' data-userid='{$row['id_mahasiswa']}'>
                                                      <span class='material-symbols-outlined'>folder_open</span>
                                                  </button></td>";
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

    // Change select background color
    function changeSelectColor(selectElement) {
        var selectedValue = selectElement.value;

        if (selectedValue === "dijadwalkan") {
            selectElement.style.backgroundColor = "rgb(255, 251, 0)";
        } else if (selectedValue === "ditunda") {
            selectElement.style.backgroundColor = "rgb(255, 99, 71)";
        } else if (selectedValue === "selesai") {
            selectElement.style.backgroundColor = "rgb(34, 139, 34)";
        }
    }

    document.querySelectorAll("select[name='status_ujian']").forEach(function (select) {
        changeSelectColor(select);
    });

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

</script>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin ../../Template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span> 
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
  <script src="../../Template/skydash/js/settings.js"></script>
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

