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
  <link rel="stylesheet" href="../../assets/css/admin/kumpulanstylediadmin.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=folder_open" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

      <?php
          include "sidebar.php";

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
          
<div class="row">  
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4>Pendaftar Tugas Akhir Politeknik Nest Sukoharjo</h4>
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
  <script src="../../Template/skydash/js/settings.js"></script>s
  <script src="../../Template/skydash/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../Template/skydash/js/dashboard.js"></script>
  <script src="../../Template/skydash/js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

