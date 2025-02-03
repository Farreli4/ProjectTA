<?php
session_start();
include '../../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);


    // Tambahkan debug
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Query untuk mencocokkan username dan password
    $query = "SELECT * FROM dosen_pembimbing WHERE username='$username' AND pass='$password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Tampilkan error MySQL jika query gagal
        $error = "Query error: " . mysqli_error($conn);
    } else if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];

        // Pastikan header belum terkirim
        if (!headers_sent()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Headers already sent. Using JavaScript redirect...";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dosen Pembimbing</title>
    <link rel="stylesheet" href="../../Template/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../Template/skydash/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="../../assets/css/css/dospem/dospem.css">
    <link rel="shortcut icon" href="../../Template/skydash/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="../../assets/img/logo2.png" alt="logo">
                            </div>
                            <h4>Hello! Let's get started</h4>

                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form class="pt-3" method="POST">
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control form-control-lg" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" name="pass" id="password" placeholder="Password" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn border-0 bg-transparent" style="margin-left: -40px;" onclick="togglePassword()">
                                                <i class="fas fa-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="g-recaptcha" data-sitekey="6Ldxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"></div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn w-100">LOGIN</button>
                                </div>
                            </form>

                            <!-- Add Font Awesome for the eye icon -->
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

                            <!-- Add Google reCAPTCHA -->
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                            <script>
                                function togglePassword() {
                                    const passwordInput = document.getElementById('password');
                                    const toggleIcon = document.getElementById('toggleIcon');

                                    if (passwordInput.type === 'password') {
                                        passwordInput.type = 'text';
                                        toggleIcon.classList.remove('fa-eye');
                                        toggleIcon.classList.add('fa-eye-slash');
                                    } else {
                                        passwordInput.type = 'password';
                                        toggleIcon.classList.remove('fa-eye-slash');
                                        toggleIcon.classList.add('fa-eye');
                                    }
                                }
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../Template/skydash/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../Template/skydash/js/off-canvas.js"></script>
    <script src="../../Template/skydash/js/hoverable-collapse.js"></script>
    <script src="../../Template/skydash/js/settings.js"></script>
    <script src="../../Template/skydash/js/todolist.js"></script>
</body>

</html>