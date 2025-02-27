<?php
include '../../config/connection.php';
session_start();
$nama_mahasiswa = $_SESSION['username'] ?? 'farel';

try {
  $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Get student info and id_mahasiswa in one query
  $check = "SELECT m.nim, m.nama_mahasiswa, m.prodi, m.id_mahasiswa 
            FROM mahasiswa m 
            WHERE m.username = :nama";
  $stmt = $conn2->prepare($check);
  $stmt->execute([':nama' => $nama_mahasiswa]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    $nim = $row['nim'];
    $nama = $row['nama_mahasiswa'];
    $prodi = $row['prodi'];
    $id_mahasiswa = $row['id_mahasiswa'];

    // Get nilai from ujian table using the retrieved id_mahasiswa
    $nilai_query = "SELECT nilai FROM ujian WHERE id_mahasiswa = :id_mahasiswa";
    $nilai_stmt = $conn2->prepare($nilai_query);
    $nilai_stmt->execute([':id_mahasiswa' => $id_mahasiswa]);
    $nilai_row = $nilai_stmt->fetch(PDO::FETCH_ASSOC);

    $nilai = $nilai_row ? $nilai_row['nilai'] : 'Belum ada nilai';
  } else {
    $nim = 'K3522068';
    $nama = 'Nama Default';
    $prodi = 'PRODI';
    $nilai = 'Belum ada nilai';
  }

  // For debugging - can be removed in production
  if (isset($id_mahasiswa)) {
    echo "<!-- Debug info: id_mahasiswa = " . htmlspecialchars($id_mahasiswa) . " -->";
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Hasil Nilai</title>
  <!-- plugins:css -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <link rel="shortcut icon" href="../../assets/img/Logo.webp" />
  <link rel="stylesheet" type="text/css" href="../../assets/css/user/dashboards.css" />
</head>
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
              <a class="dropdown-item" href="../../index.php">
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
            <a class="nav-link" href="../../index.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Log Out</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- MAIN-->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <h1>Data Ujian</h1>
            <div class="info-box">
              <p>
                <span class="label" style="font-size: 18px; font-weight: bold;">Nama Mahasiswa:</span>
                <span class="value" style="font-size: 18px;"><?php echo htmlspecialchars($nama); ?></span>
              </p>
              <p>
                <span class="label" style="font-size: 18px; font-weight: bold;">NIM:</span>
                <span class="value" style="font-size: 18px;"><?php echo htmlspecialchars($nim); ?></span>
              </p>
              <p>
                <span class="label" style="font-size: 18px; font-weight: bold;">Program Studi:</span>
                <span class="value" style="font-size: 18px;"><?php echo htmlspecialchars($prodi); ?></span>
              </p>
            </div>

            <div class="result-box">
              <h2>Hasil Ujian Anda</h2>
              <div class="score">
                <?php
                if ($nilai !== 'Belum ada nilai') {
                  echo htmlspecialchars($nilai);
                } else {
                  echo "Belum ada nilai";
                }
                ?>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer" style="display: flex;">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block" style="text-align: center; justify-content: center;">Copyright © 2023. <a href="https://www.bootstrapdash.com/" target="_blank">Politeknik NEST</a> Teknologi Informasi</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <style>
      .container {
        margin-bottom: 100px;
      }

      .info-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
      }

      .result-box {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center;
      }

      .score {
        font-size: 48px;
        color: #4B49AC;
        font-weight: bold;
        margin: 20px 0;
      }

      .label {
        font-weight: bold;
        color: #4B49AC;
      }
    </style>
    <script>
  $(document).ready(function() {
    // Create a search results container
    $('body').append('<div id="search-results" style="display: none; position: absolute; top: 60px; right: 20px; width: 300px; max-height: 400px; overflow-y: auto; background: white; border: 1px solid #ddd; border-radius: 4px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"></div>');

    // Search function
    $("#navbar-search-input").on("keyup", function() {
      var searchText = $(this).val().toLowerCase().trim();
      var resultsContainer = $("#search-results");
      resultsContainer.empty();

      if (searchText.length < 2) {
        resultsContainer.hide();
        return;
      }

      // Search in all clickable elements with text
      var results = [];

      // Search in menu items
      $(".nav-item a").each(function() {
        var link = $(this);
        var text = link.text().trim();

        if (text.toLowerCase().indexOf(searchText) > -1) {
          results.push({
            element: link,
            text: text,
            type: 'Menu Item',
            href: link.attr('href')
          });
        }
      });

      // Search in cards
      $(".card, .submission-card").each(function() {
        var card = $(this);
        var cardText = card.text().trim();
        var link = card.closest('a');

        if (cardText.toLowerCase().indexOf(searchText) > -1 && link.length) {
          results.push({
            element: link,
            text: cardText.substring(0, 30) + (cardText.length > 30 ? '...' : ''),
            type: 'Card',
            href: link.attr('href')
          });
        }
      });

      // Display results
      if (results.length > 0) {
        resultsContainer.append('<div style="padding: 10px; background: #f8f9fa; border-bottom: 1px solid #ddd;"><strong>Search Results</strong></div>');

        for (var i = 0; i < results.length; i++) {
          var result = results[i];
          resultsContainer.append(
            '<div class="search-result-item" style="padding: 10px; border-bottom: 1px solid #eee; cursor: pointer;" data-href="' +
            result.href + '">' +
            '<div style="font-size: 12px; color: #6c757d;">' + result.type + '</div>' +
            '<div>' + highlightText(result.text, searchText) + '</div>' +
            '</div>'
          );
        }

        resultsContainer.show();
      } else {
        resultsContainer.append('<div style="padding: 10px;">No results found</div>');
        resultsContainer.show();
      }
    });

    // Handle clicking on search results
    $(document).on('click', '.search-result-item', function() {
      var href = $(this).data('href');
      if (href && href !== '#' && href !== 'javascript:void(0)') {
        window.location.href = href;
      } else {
        // Handle items without a direct href (like dropdown toggles)
        var searchText = $("#navbar-search-input").val().toLowerCase();
        var clicked = false;

        // Try to click on the matching menu item
        $(".nav-item a").each(function() {
          if (!clicked && $(this).text().toLowerCase().indexOf(searchText) > -1) {
            $(this).click();
            clicked = true;
            return false;
          }
        });

        // If no menu item was clicked, try to click on matching card
        if (!clicked) {
          $(".card, .submission-card").each(function() {
            if (!clicked && $(this).text().toLowerCase().indexOf(searchText) > -1) {
              $(this).closest('a').click();
              clicked = true;
              return false;
            }
          });
        }
      }

      $("#search-results").hide();
    });

    // Close search results when clicking outside
    $(document).on('click', function(e) {
      if (!$(e.target).closest('#search-results').length && !$(e.target).closest('#navbar-search-input').length) {
        $("#search-results").hide();
      }
    });

    // Close search results when pressing Escape
    $(document).on('keydown', function(e) {
      if (e.key === "Escape") {
        $("#search-results").hide();
      }
    });

    // Helper function to highlight search text
    function highlightText(text, searchText) {
      if (!text) return '';

      var index = text.toLowerCase().indexOf(searchText.toLowerCase());
      if (index >= 0) {
        return text.substring(0, index) +
          '<span style="background-color: #ffeb3b; font-weight: bold;">' +
          text.substring(index, index + searchText.length) +
          '</span>' +
          text.substring(index + searchText.length);
      }
      return text;
    }
  });
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