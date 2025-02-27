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
  <title>Daftar Mahasiswa</title>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
     <?php
    include "bar.php";
    ?>
      <!-- partial -->

      <style>
        .nav-link.active {
          background: #193042;
          position: relative;
          color: white !important;
        }

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
                  <p class="card-title">Daftar Mahasiswa</p>
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
                              <th>Kelas</th>
                              <th>Nomor Telepon</th>
                              <th>Username</th>
                              <th>Password</th>
                              <th>Edit</th>
                              <th>Hapus</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $sql1 = "SELECT id_mahasiswa, nama_mahasiswa, nim, prodi, kelas, nomor_telepon, username, pass FROM mahasiswa WHERE 1";
                            $result = $conn->query($sql1);

                            while ($row = mysqli_fetch_array($result)) {
                              echo "<tr>";
                              echo "<td>" . $row['id_mahasiswa'] . "</td>";
                              echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                              echo "<td>" . $row['nim'] . "</td>";
                              echo "<td>" . $row['prodi'] . "</td>";
                              echo "<td>" . $row['kelas'] . "</td>";
                              echo "<td>" . $row['nomor_telepon'] . "</td>";
                              echo "<td>" . $row['username'] . "</td>";
                              echo "<td>" . $row['pass'] . "</td>";
                              echo "<td><button class='editBtn' data-id='" . $row['id_mahasiswa'] . "' data-nama='" . $row['nama_mahasiswa'] . "' data-nim='" . $row['nim'] . "' data-prodi='" . $row['prodi'] . "' data-kelas='" . $row['kelas'] . "' data-telepon='" . $row['nomor_telepon'] . "' data-username='" . $row['username'] . "'>Edit</button></td>";
                              echo "<td><button class='deleteBtn' data-id='" . $row['id_mahasiswa'] . "'>Hapus</button></td>";
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
            <button id="openModalBtn" class="btn btn-primary btn-spacing">Add Data</button>
            <button id="openModal" class="btn btn-primary">Add Batch</button>

            <div id="myModal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add Student Data</h2>
                <form id="studentForm">
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="nama_mahasiswa" required>
                  </div>

                  <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required>
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
                    <label for="class">Class:</label>
                    <input type="text" id="class" name="kelas" required>
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
              <form action="upload_aksi.php" method="post" enctype="multipart/form-data">
                <label for="file">Choose an Excel file to upload:</label>
                <input type="file" name="excel_file" id="excel_file" required>
                <button type="submit" name="submit">Upload</button>
              </form>
              </div>
            </div>

            <div id="editModal" class="modal">
              <div class="modal-content">
                <span class="close" id="closeEditModal">&times;</span>
                <h2>Edit Data Mahasiswa</h2>
                <form id="editForm">
                  <input type="hidden" id="edit_id" name="id_mahasiswa">

                  <div class="form-group">
                    <label for="edit_name">Nama:</label>
                    <input type="text" id="edit_name" name="nama_mahasiswa" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_nim">NIM:</label>
                    <input type="text" id="edit_nim" name="nim" required>
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
                    <label for="edit_kelas">Kelas:</label>
                    <input type="text" id="edit_kelas" name="kelas" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_telepon">Nomor Telepon:</label>
                    <input type="text" id="edit_telepon" name="nomor_telepon" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_username">Username:</label>
                    <input type="text" id="edit_username" name="username" required>
                  </div>

                  <div class="form-group">
                    <label for="edit_username">Password:</label>
                    <input type="password" id="edit_password" name="password" required>
                  </div>

                  <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </form>
              </div>
            </div>


            <style>
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
                  padding: 20px; /* Ensures space around the modal */
              }

              .modal-content {
                  background-color: #fff;
                  padding: 20px;
                  border-radius: 8px;
                  width: 40%;
                  max-width: 600px;
                  height: 80vh;
                  flex-direction: column;
                  overflow: hidden; /* Prevents unnecessary scrolling */
              }

              .modal-content form {
                  flex-grow: 1; /* Ensures form takes available space */
                  overflow-y: auto; /* Allows scrolling within form */
                  max-height: calc(80vh - 40px); /* Ensures form doesn't overflow */
              }

              .close {
                  color: #555;
                  position: absolute;
                  right: 15px;
                  top: 10px;
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

              .btn-spacing {
                margin-right: 10px; /* Atur jarak sesuai keinginan */
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

              document.getElementById("studentForm").onsubmit = function(event) {
                event.preventDefault();

                var name = document.getElementById("name").value;
                var nim = document.getElementById("nim").value;
                var phone = document.getElementById("phone").value;

                console.log('Form data:', {
                  name,
                  nim,
                  phone
                });

                if (name === "" || nim === "" || phone === "") {
                  Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill in all fields!'
                  });
                  return;
                }

                var phoneRegex = /^[0-9]{10,15}$/;
                if (!phoneRegex.test(phone)) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Invalid Phone Number',
                    text: 'Please enter a valid phone number.'
                  });
                  return;
                }

                var formData = new FormData(document.getElementById("studentForm"));

                Swal.fire({
                  title: 'Are you sure?',
                  text: "Do you want to submit this data?",
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "addSiswa.php", true);
                    xhr.onload = function() {
                      console.log('Response from PHP:', xhr.responseText);
                      if (xhr.status === 200) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Success!',
                          text: 'Data added successfully!'
                        }).then(() => {
                          document.getElementById("myModal").style.display = "none";
                          document.getElementById("studentForm").reset();
                        });
                      } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error: ' + xhr.statusText
                        });
                      }
                    };
                    xhr.onerror = function() {
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred during the request. Please try again.'
                      });
                    };
                    xhr.send(formData);
                  }
                });
              };
            </script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                // Fungsi untuk membuka modal edit dan mengisi data ke dalam form
                document.body.addEventListener("click", function(event) {
                  if (event.target.classList.contains("editBtn")) {
                    document.getElementById("edit_id").value = event.target.getAttribute("data-id");
                    document.getElementById("edit_name").value = event.target.getAttribute("data-nama");
                    document.getElementById("edit_nim").value = event.target.getAttribute("data-nim");
                    document.getElementById("edit_prodi").value = event.target.getAttribute("data-prodi");
                    document.getElementById("edit_kelas").value = event.target.getAttribute("data-kelas");
                    document.getElementById("edit_telepon").value = event.target.getAttribute("data-telepon");
                    document.getElementById("edit_username").value = event.target.getAttribute("data-username");
                    document.getElementById("edit_password").value = event.target.getAttribute("data-password");

                    document.getElementById("editModal").style.display = "flex";
                  }
                });

                // Menutup modal edit
                document.getElementById("closeEditModal").onclick = function() {
                  document.getElementById("editModal").style.display = "none";
                };

                // Kirim data edit ke PHP dengan SweetAlert2
                document.getElementById("editForm").onsubmit = function(event) {
                  event.preventDefault();

                  var formData = new FormData(document.getElementById("editForm"));

                  var xhr = new XMLHttpRequest();
                  xhr.open("POST", "editSiswa.php", true);
                  xhr.onload = function() {
                    if (xhr.status === 200) {
                      Swal.fire({
                        title: "Berhasil!",
                        text: "Data mahasiswa berhasil diperbarui.",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                      }).then(() => {
                        document.getElementById("editModal").style.display = "none";
                        location.reload();
                      });
                    } else {
                      Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan: " + xhr.statusText,
                        icon: "error",
                        confirmButtonColor: "#d33"
                      });
                    }
                  };
                  xhr.onerror = function() {
                    Swal.fire({
                      title: "Kesalahan!",
                      text: "Terjadi kesalahan dalam koneksi.",
                      icon: "error",
                      confirmButtonColor: "#d33"
                    });
                  };
                  xhr.send(formData);
                };

                // Menggunakan SweetAlert2 untuk konfirmasi hapus
                document.body.addEventListener("click", function(event) {
                  if (event.target.classList.contains("deleteBtn")) {
                    let id = event.target.getAttribute("data-id");

                    Swal.fire({
                      title: "Apakah Anda yakin?",
                      text: "Data mahasiswa ini akan dihapus secara permanen!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#d33",
                      cancelButtonColor: "#3085d6",
                      confirmButtonText: "Ya, Hapus!",
                      cancelButtonText: "Batal"
                    }).then((result) => {
                      if (result.isConfirmed) {
                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "deleteSiswa.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                          if (xhr.readyState === 4 && xhr.status === 200) {
                            Swal.fire(
                              "Terhapus!",
                              "Data mahasiswa telah berhasil dihapus.",
                              "success"
                            ).then(() => {
                              location.reload();
                            });
                          }
                        };
                        xhr.send("id_mahasiswa=" + id);
                      }
                    });
                  }
                });
              });
            </script>



          </div>
        </div>
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