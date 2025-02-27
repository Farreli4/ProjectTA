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
  $nama_admin = $row['nama_admin'];
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
  <title>Daftar Dosen</title>
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
  <link rel="stylesheet" href="../../assets/css/admin/kumpulanstylediadmin.css">
  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/mahasiswa.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php
    include "sidebar.php";
    ?>
      <!-- partial -->

      <style>
        /* Styling Tabel */
        /* Styling Tabel */
        /* Styling Tabel */
        /* Styling Tabel */
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
        th,
        td {
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

      <!--Advanced-->
      <div class="main-panel">
        <div class="content-wrapper">
          <!--Advanced-->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Daftar Dosen</p>
                  <div class="row">
                    <div class="col-12">
                      <?php

                      if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                      }

                      $limit = 10;
                      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $offset = ($page - 1) * $limit;

                      $sql1 = "SELECT id_dosen, nama_dosen, nip, prodi, nomor_telepon, username, pass FROM dosen_pembimbing LIMIT $limit OFFSET $offset";
                      $result = $conn->query($sql1);

                      $totalQuery = "SELECT COUNT(id_dosen) AS total FROM dosen_pembimbing";
                      $totalResult = $conn->query($totalQuery);
                      $totalRow = $totalResult->fetch_assoc();
                      $totalData = $totalRow['total'];
                      $totalPages = ceil($totalData / $limit);
                      ?>

                      <div style="overflow-x: auto;">
                        <table id="example" class="display expandable-table" style="width:100%; white-space: nowrap;">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Nama</th>
                              <th>NIP</th>
                              <th>Program Studi</th>
                              <th>Nomor Telepon</th>
                              <th>Username</th>
                              <th>Password</th>
                              <th>Edit</th>
                              <th>Hapus</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td>" . $row['id_dosen'] . "</td>";
                              echo "<td>" . $row['nama_dosen'] . "</td>";
                              echo "<td>" . $row['nip'] . "</td>";
                              echo "<td>" . $row['prodi'] . "</td>";
                              echo "<td>" . $row['nomor_telepon'] . "</td>";
                              echo "<td>" . $row['username'] . "</td>";
                              echo "<td>" . $row['pass'] . "</td>";
                              echo "<td><button class='editBtn' data-id='" . $row['id_dosen'] . "'>Edit</button></td>";
                              echo "<td><button class='deleteBtn' data-id='" . $row['id_dosen'] . "'>Hapus</button></td>";
                              echo "</tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>

                      <hr>

                      <div class="pagination-container">
                        <div class="pagination-info">PAGES <?php echo $page; ?> OF <?php echo $totalPages; ?></div>
                        <div class="pagination">
                          <?php if ($page > 1): ?>
                            <a href="?page=1" class="btn">FIRST</a>
                            <a href="?page=<?php echo $page - 1; ?>" class="btn">PREV</a>
                          <?php endif; ?>

                          <?php
                          if ($totalPages <= 10) {
                            for ($i = 1; $i <= $totalPages; $i++) {
                              echo "<a href='?page=$i' class='btn " . ($i == $page ? "active" : "") . "'>$i</a>";
                            }
                          } else {
                            if ($page > 3) echo "<a href='?page=1' class='btn'>1</a> ... ";

                            for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
                              echo "<a href='?page=$i' class='btn " . ($i == $page ? "active" : "") . "'>$i</a>";
                            }

                            if ($page < $totalPages - 2) echo " ... <a href='?page=$totalPages' class='btn'>$totalPages</a>";
                          }
                          ?>

                          <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="btn">NEXT</a>
                            <a href="?page=<?php echo $totalPages; ?>" class="btn">LAST</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>

                    <style>
                      .pagination-container {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        margin-top: 20px;
                        width: 100%;
                      }

                      .pagination-info {
                        background-color: #333;
                        color: white;
                        padding: 8px 12px;
                        margin-right: 10px;
                        border-radius: 5px;
                      }

                      .pagination {
                        display: flex;
                      }

                      .pagination .btn {
                        margin: 0 3px;
                        padding: 8px 12px;
                        text-decoration: none;
                        background-color: #007bff;
                        color: white;
                        border-radius: 5px;
                      }

                      .pagination .btn.active {
                        background-color: #7E99A3;
                      }
                    </style>

                    <?php
                    $conn->close();
                    ?>

                  </div>
                </div>
              </div>
            </div>
            <button id="openModalBtn" class="btn btn-primary btn-spacing">Add Data</button>
            <button id="openModal" class="btn btn-primary">Add Batch</button>

            <div id="myModal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add Data Dosen</h2>
                <form id="studentForm">
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="nama_dosen" required>
                  </div>

                  <div class="form-group">
                    <label for="nim">NIP:</label>
                    <input type="text" id="nip" name="nip" required>
                  </div>

                  <div class="form-group">
                    <label for="program">Program Studi:</label>
                    <select id="program" name="prodi" required>
                      <option value="Teknologi Informasi">Teknologi Informasi</option>
                      <option value="Seni Kuliner">Seni Kuliner</option>
                      <option value="Perhotelan">Perhotelan</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phone" name="nomor_telepon" required>
                  </div>

                  <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                  </div>

                  <div class="form-group">
                    <label for="pass">Password:</label>
                    <input type="password" id="pass" name="pass" required>
                  </div>

                  <button type="submit" id="submitBtn" class="btn-submit">Submit</button>
                </form>
              </div>
            </div>

            <div id="ModalBatch" class="modal">
              <div class="modal-content">
                <span class="close" id="closeModalBatch">&times;</span>
                <form action="upload_aksi_dosen.php" method="post" enctype="multipart/form-data">
                  <label for="file">Choose an Excel file to upload:</label>
                  <input type="file" name="excel_file" id="excel_file" required>
                  <button type="submit" name="submit">Upload</button>
                </form>
              </div>
            </div>

            <div id="editModal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Data Dosen</h2>
                <form id="editForm">
                  <input type="hidden" id="edit_id" name="id_dosen">

                  <div class="form-group">
                    <label for="edit_name">Nama:</label>
                    <input type="text" id="edit_name" name="nama_dosen" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_nip">NIP:</label>
                    <input type="text" id="edit_nip" name="nip" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_prodi">Program Studi:</label>
                    <select id="edit_prodi" name="prodi" required>
                      <option value="Teknologi Informasi">Teknologi Informasi</option>
                      <option value="Seni Kuliner">Seni Kuliner</option>
                      <option value="Perhotelan">Perhotelan</option>
                    </select>
                  </div>


                  <div class="form-group">
                    <label for="edit_phone">Nomor Telepon:</label>
                    <input type="text" id="edit_phone" name="nomor_telepon" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_username">Username:</label>
                    <input type="text" id="edit_username" name="username" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_pass">Password:</label>
                    <input type="password" id="edit_pass" name="pass" required>
                  </div>

                  <button type="submit" class="btn-submit">Update</button>
                </form>
              </div>
            </div>


            <style>
              /* Styling untuk modal */
              .nav-link.active {
                background: #193042;
                position: relative;
                color: white !important;
              }

              .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
                padding: 20px;
                /* Ensures space around the modal */
              }

              .modal-content {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                width: 40%;
                max-width: 600px;
                height: 80vh;
                flex-direction: column;
                overflow: hidden;
                /* Prevents unnecessary scrolling */
              }

              .modal-content form {
                flex-grow: 1;
                /* Ensures form takes available space */
                overflow-y: auto;
                /* Allows scrolling within form */
                max-height: calc(80vh - 40px);
                /* Ensures form doesn't overflow */
              }

              .close {
                color: #555;
                float: right;
                font-size: 24px;
                font-weight: bold;
                cursor: pointer;
              }

              .close:hover {
                color: red;
              }

              /* Styling untuk form */
              .form-group {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;
              }

              label {
                font-weight: bold;
                margin-bottom: 5px;
              }

              input {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
                width: 100%;
                outline: none;
                /* Menghilangkan border bawaan browser */
                transition: border 0.3s ease-in-out;
              }

              /* Saat input dalam keadaan aktif (focus) */
              input:focus {
                border: 2px solid #007bff;
                /* Border tetap muncul dengan warna biru */
                box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
                /* Efek glow */
              }

              select {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
                width: 100%;
                outline: none;
                background-color: white;
                font-size: 16px;
                transition: border 0.3s ease-in-out;
              }

              select:focus {
                border: 2px solid #007bff;
                box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
              }

              .btn-submit {
                background-color: #007bff;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
              }

              .btn-submit:hover {
                background-color: #0056b3;
              }

              .editBtn {
                background-color: #007bff;
                /* Warna biru */
                color: white;
                /* Warna teks putih */
                border: none;
                /* Hapus border */
                padding: 8px 16px;
                /* Ukuran padding */
                border-radius: 8px;
                /* Membuat sudut membulat */
                cursor: pointer;
                /* Ubah kursor menjadi pointer */
                font-size: 14px;
                transition: background 0.3s ease-in-out;
              }

              .editBtn:hover {
                background-color: #0056b3;
                /* Warna biru lebih gelap saat hover */
              }

              .btn-spacing {
                margin-right: 10px;
                /* Atur jarak sesuai keinginan */
              }

              .deleteBtn {
                background-color: #dc3545;
                /* Warna merah */
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 14px;
                transition: background 0.3s ease-in-out;
              }

              .deleteBtn:hover {
                background-color: #c82333;
                /* Warna merah lebih gelap */
              }
            </style>

            <script>
              document.getElementById("openModalBtn").onclick = function() {
                document.getElementById("myModal").style.display = "flex";
              }

              document.querySelector(".close").onclick = function() {
                document.getElementById("myModal").style.display = "none";
              }

              document.getElementById("openModal").onclick = function() {
                document.getElementById("ModalBatch").style.display = "flex";
              }

              document.getElementById("closeModalBatch").onclick = function() {
                document.getElementById("ModalBatch").style.display = "none";
              }


              window.onclick = function(event) {
                if (event.target == document.getElementById("myModal")) {
                  document.getElementById("myModal").style.display = "none";
                }
              }

              document.getElementById("openModalBtn").onclick = function() {
                document.getElementById("myModal").style.display = "flex";
              };

              document.getElementsByClassName(".close")[0].onclick = function() {
                document.getElementById("myModal").style.display = "none";
              };

              document.querySelectorAll(".editBtn").forEach(button => {
                button.addEventListener("click", function() {
                  var id = this.getAttribute("data-id");

                  fetch(`getDosen.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                      document.getElementById("edit_id").value = data.id_dosen;
                      document.getElementById("edit_name").value = data.nama_dosen;
                      document.getElementById("edit_nip").value = data.nip;
                      document.getElementById("edit_prodi").value = data.prodi;
                      document.getElementById("edit_phone").value = data.nomor_telepon;
                      document.getElementById("edit_username").value = data.username;
                      document.getElementById("edit_pass").value = data.pass;

                      document.getElementById("editModal").style.display = "flex";
                    })
                    .catch(error => console.error("Error fetching data:", error));
                });
              });

              document.querySelector("#editModal .close").onclick = function() {
                document.getElementById("editModal").style.display = "none";
              };

              document.getElementById("editForm").onsubmit = function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById("editForm"));

                fetch("editDosen.php", {
                    method: "POST",
                    body: formData
                  })
                  .then(response => response.text())
                  .then(response => {
                    Swal.fire({
                      icon: "success",
                      title: "Berhasil!",
                      text: "Data berhasil diperbarui!",
                    }).then(() => {
                      document.getElementById("editModal").style.display = "none";
                      location.reload();
                    });
                  })
                  .catch(error => console.error("Error:", error));
              };
              document.getElementById("openModal").onclick = function() {
                document.getElementById("ModalBatch").style.display = "flex";
              }

              document.querySelector(".close").onclick = function() {
                document.getElementById("ModalBatch").style.display = "none";
              }

              window.onclick = function(event) {
                if (event.target == document.getElementById("myModal")) {
                  document.getElementById("myModal").style.display = "none";
                }
              };

              document.querySelectorAll(".editBtn").forEach(button => {
                button.addEventListener("click", function() {
                  var id = this.getAttribute("data-id");

                  fetch(`getDosen.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                      document.getElementById("edit_id").value = data.id_dosen;
                      document.getElementById("edit_name").value = data.nama_dosen;
                      document.getElementById("edit_nip").value = data.nip;
                      document.getElementById("edit_prodi").value = data.prodi;
                      document.getElementById("edit_phone").value = data.nomor_telepon;
                      document.getElementById("edit_username").value = data.username;
                      document.getElementById("edit_pass").value = data.pass;

                      document.getElementById("editModal").style.display = "flex";
                    })
                    .catch(error => console.error("Error fetching data:", error));
                });
              });

              document.querySelector("#editModal .close").onclick = function() {
                document.getElementById("editModal").style.display = "none";
              };

              document.getElementById("editForm").onsubmit = function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById("editForm"));

                fetch("editDosen.php", {
                    method: "POST",
                    body: formData
                  })
                  .then(response => response.text())
                  .then(response => {
                    Swal.fire({
                      icon: "success",
                      title: "Berhasil!",
                      text: "Data berhasil diperbarui!",
                    }).then(() => {
                      document.getElementById("editModal").style.display = "none";
                      location.reload();
                    });
                  })
                  .catch(error => console.error("Error:", error));
              };

              document.getElementById("studentForm").onsubmit = function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById("studentForm"));

                fetch("addDosen.php", {
                    method: "POST",
                    body: formData
                  })
                  .then(response => response.text())
                  .then(response => {
                    Swal.fire({
                      icon: "success",
                      title: "Berhasil!",
                      text: "Data dosen berhasil ditambahkan!",
                    }).then(() => {
                      document.getElementById("myModal").style.display = "none";
                      document.getElementById("studentForm").reset();
                    });
                  })
                  .catch(error => console.error("Error:", error));
              };

              document.querySelectorAll(".deleteBtn").forEach(button => {
                button.addEventListener("click", function() {
                  let id = this.getAttribute("data-id");

                  Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                  }).then((result) => {
                    if (result.isConfirmed) {
                      fetch("deleteDosen.php", {
                          method: "POST",
                          headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                          },
                          body: "id_dosen=" + id
                        })
                        .then(response => response.text())
                        .then(response => {
                          Swal.fire({
                            icon: "success",
                            title: "Terhapus!",
                            text: "Data dosen telah dihapus.",
                          }).then(() => {
                            location.reload();
                          });
                        });
                    }
                  });
                });
              });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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