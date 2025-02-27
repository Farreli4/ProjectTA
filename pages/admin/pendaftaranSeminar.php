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
  <title>Pendaftaran Seminar Proposal</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/admin/kumpulanstylediadmin.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=folder_open" />
  
  <script>
  function changeSelectColor(selectElement) {
    var selectedValue = selectElement.value;

    if (selectedValue == 'dijadwalkan') {
      selectElement.style.backgroundColor = 'rgb(255, 251, 0)'; 
    } else if (selectedValue == 'ditunda') {
      selectElement.style.backgroundColor = 'rgb(255, 99, 71)'; 
    } else if (selectedValue == 'selesai') {
      selectElement.style.backgroundColor = 'rgb(34, 139, 34)'; 
    }
  }

  window.onload = function() {
    var selects = document.querySelectorAll('select');
    selects.forEach(function(select) {
      changeSelectColor(select); 
    });
  }
</script>


</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
     <?php
    include "bar.php";
    ?>
      <!-- partial -->
      <?php

          // Ambil total pendaftar tugas akhir
          $sqlSeminar = "SELECT COUNT(*) AS total FROM seminar_proposal";
          $resultSeminar = $conn->query($sqlSeminar);
          $totalSeminar = ($resultSeminar->num_rows > 0) ? $resultSeminar->fetch_assoc()['total'] : 0;
      ?>
      
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-md-5 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body text-center">
                      <p class="mb-4">Total Pendaftar Seminar</p>
                      <p class="fs-30 mb-2"><?php echo number_format($totalSeminar); ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                
                
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
                  <canvas id="myChart2"></canvas>
                  <script>
                    var xValues = <?php echo json_encode($xValues); ?>; 
                    var yValues = <?php echo json_encode($yValues); ?>;

                    var barColors = ["#ebd382", "#d25d5d", "#73ad91",];

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

          <div class="row"> 
              <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <p class="card-title">Jadwal Seminar Proposal</p>
                          <div class="table-responsive">
                              <table>
                                  <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>Nama</th>
                                          <th>NIM</th>
                                          <th>Jadwal</th>
                                          <th>Status</th>
                                          <th>Update Status</th>
                                          <th>Dokumen</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                    $conn = new mysqli("127.0.0.1", "root", "", "sistem_ta");

                                    $sql1 = "SELECT mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa, mahasiswa.nim, seminar_proposal.tanggal_seminar, seminar_proposal.status_seminar
                                            FROM mahasiswa 
                                            LEFT JOIN seminar_proposal ON mahasiswa.id_mahasiswa = seminar_proposal.id_mahasiswa";
                                    $result = $conn->query($sql1);

                                    $event = "seminar_proposal";

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_mahasiswa'] . "</td>";
                                        echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                                        echo "<td>" . $row['nim'] . "</td>";
                                        echo "<td>";
                                        echo "<form action='update_seminar.php' method='POST'>";
                                        echo "<input type='date' name='tanggal_seminar' value='" . $row["tanggal_seminar"] . "' required>";
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<select name='status_seminar' class='status-select' required>";
                                        echo "<option value='dijadwalkan'" . ($row['status_seminar'] == 'dijadwalkan' ? ' selected' : '') . ">Dijadwalkan</option>";
                                        echo "<option value='ditunda'" . ($row['status_seminar'] == 'ditunda' ? ' selected' : '') . ">Ditunda</option>";
                                        echo "<option value='selesai'" . ($row['status_seminar'] == 'selesai' ? ' selected' : '') . ">Selesai</option>";
                                        echo "</select>";
                                        echo "<input type='hidden' name='id_mahasiswa' value='" . $row['id_mahasiswa'] . "'>";
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<button type='submit' class='btn-update'>Update</button>";
                                        echo "</form>";
                                        echo "<td><button class='folder-btn' data-event='" . $event . "' data-userid='" . $row['id_mahasiswa'] . "'><span class='material-symbols-outlined'>folder_open</span></button></td>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    ?>

                                  </tbody>
                              </table>
                          </div>
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

    document.addEventListener("change", function (event) {
        if (event.target.matches("select[name='status_ujian']")) {
            changeSelectColor(event.target);
        }
    });

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
  <script src="../../Template/skydash/js/settings.js"></script>
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

