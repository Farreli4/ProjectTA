<?php
session_start();
include 'config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $admin_username = "admin";
    $admin_password = "admin";

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['username'] = $username;

        header("Location: pages/admin/index.php");
        exit();
    } else {
        $query = "SELECT 'dosen_pembimbing' AS source_table, id_dosen, username, pass, nip FROM dosen_pembimbing WHERE username = '$username'
          UNION 
          SELECT 'mahasiswa' AS source_table, id_mahasiswa, username, pass, nim FROM mahasiswa WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $error = "Query error: " . mysqli_error($conn);
        } else if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $hashedPass = $row['pass'];

            if (password_verify($password, $hashedPass)) {
                if ($row['source_table'] === 'dosen_pembimbing') {
                    $redirectUrl = "pages/dospem/index.php";
                } elseif ($row['source_table'] === 'mahasiswa') {
                    $redirectUrl = "pages/user/dashboard.php";
                } else {
                    $error = "Invalid source table!";
                    $redirectUrl = "login.php";
                }
            }else{
                echo "Password salah";
            }

            if (!isset($error)) {
                if (!headers_sent()) {
                    header("Location: " . $redirectUrl);
                    exit();
                } else {
                    echo "Headers already sent. Using JavaScript redirect...";
                    echo "<script>window.location.href = '$redirectUrl';</script>";
                    exit();
                }
            } else {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $error = "Username or Password is incorrect!";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Informasi Tugas Akhir</title>
    <link rel="stylesheet" href="Template/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="Template/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="Template/skydash/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="Template/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="Template/skydash/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="assets/css/css/dospem/dospem.css">
    <link rel="shortcut icon" href="Template/skydash/images/favicon.png" />
    <style>
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .password-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .password-toggle label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }

        .form-control {
            border-radius: 25px !important;
        }

        .btn-login {
            background-color: #4c6ef5 !important;
            border-radius: 25px !important;
            padding: 12px !important;
            font-size: 16px !important;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 300px;
            height: auto;
        }
    </style>
</head>

<body style="background-color: white;">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5 login-container logo-container">
                            <div class="logo-container">
                                <img src="assets/img/logo2.png" alt="Logo">
                            </div>
                            <h4 class="logo-container">Sistem Informasi Tugas Akhir !</h4>

                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form class="pt-3" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Masukan Akun" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="pass" id="password" placeholder="Password" required>
                                </div>
                                <div class="password-toggle">
                                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                                    <label for="showPassword">Show Password</label>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn w-100 btn-login">Login</button>
                            </form>

                            <!-- Add Google reCAPTCHA -->
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                            <script>
                                function togglePassword() {
                                    const passwordInput = document.getElementById('password');
                                    const showPassword = document.getElementById('showPassword');

                                    if (showPassword.checked) {
                                        passwordInput.type = 'text';
                                    } else {
                                        passwordInput.type = 'password';
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="Template/skydash/vendors/js/vendor.bundle.base.js"></script>
</body>

</html>