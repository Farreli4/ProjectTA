<?php include '../../config/connection.php'; ?>
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
  <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />

  <link rel="stylesheet" type="text/css" href="../../assets/css/css/admin/mahasiswa.css">
  <link rel="stylesheet" href="../../assets/css/css/admin/mahasiswa.css">
  <!-- Add these before closing </body> tag -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="collapse" data-target="#sidebar">
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
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Application Error</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-settings mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Settings</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Private message
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">New user registration</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li>
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
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table" style="width:100%">
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
                            $conn = new mysqli('127.0.0.1', 'root', '', 'sistem_ta');
                            $sql1 = "SELECT id_dosen, nama_dosen, nip, prodi, nomor_telepon, username, pass FROM dosen_pembimbing WHERE 1";
                            $result = $conn->query($sql1);

                            while ($row = mysqli_fetch_array($result)) {
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
            <button id="openModalBtn" class="btn btn-primary">Add Data</button>
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
                    <input type="text" id="program" name="prodi" required>
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
              <form action="upload_aksi_dosen.php" method="post" enctype="multipart/form-data">
                <label for="file">Choose an Excel file to upload:</label>
                <input type="file" name="excel_file" id="excel_file" required>
                <button type="submit" name="submit">Upload</button>
              </form>
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
                    <input type="text" id="edit_prodi" name="prodi" required>
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
              .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
              }

              .modal-content {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                width: 50%;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
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
            </style>

            <style>
              .modal {
                display: none;
                position: relative;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
                padding-top: 60px;
              }

              .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
              }

              .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
              }

              .close:hover,
              .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
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
              document.getElementById("openModal").onclick = function() {
                document.getElementById("ModalBatch").style.display = "flex";
              }

              document.querySelector(".close").onclick = function() {
                document.getElementById("ModalBatch").style.display = "none";
              }


              document.getElementById("openModalBtn").onclick = function() {
                document.getElementById("myModal").style.display = "flex";
              }

              document.querySelector(".close").onclick = function() {
                document.getElementById("myModal").style.display = "none";
              }

              window.onclick = function(event) {
                if (event.target == document.getElementById("myModal")) {
                  document.getElementById("myModal").style.display = "none";
                }
              }

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