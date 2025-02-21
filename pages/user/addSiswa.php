<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "sistem_ta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$status = '';
$bg_color = '';
$iconPath = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['event'])) {
        $id = $_POST['id'];
        $event = $_POST['event'];
        $check = $conn->prepare("SELECT id_mahasiswa FROM $event WHERE id_mahasiswa = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Anda sudah mensubmit sebelumnya!";
            $status = "warning";
            $bg_color = "#FFF3CD";
            $iconPath = "../../assets/img/docx_yellow.png";
        } else {
            $stmt = $conn->prepare("INSERT INTO $event (`id_mahasiswa`) VALUES (?)");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $message = "Data berhasil disubmit!";
                $status = "success";
                $bg_color = "#D4EDDA";
                $iconPath = "../../assets/img/checklist.png";
            } else {
                $message = "Error: " . $stmt->error;
                $status = "danger";
                $bg_color = "#F8D7DA";
                $iconPath = "../../assets/img/error.png";
            }

            $stmt->close();
        }

        $check->close();
    } else {
        $message = "Data yang diperlukan tidak lengkap!";
        $status = "danger";
        $bg_color = "#F8D7DA";
        $iconPath = "../../assets/img/error.png";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Submit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            background-color: <?php echo $bg_color; ?>;
            transition: background-color 0.5s ease;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 500px;
            padding: 20px;
        }
        .status-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
        }
        .icon-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }
        .icon-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .message {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: <?php 
                if($status == 'success') echo '#002737';
                else if($status == 'warning') echo '#002737';
                else echo '#002737';
            ?>;
        }
        .btn-back {
            background: <?php 
                if($status == 'success') echo '#00b6ff';
                else if($status == 'warning') echo '#00b6ff';
                else echo '#00b6ff';
            ?>;
            color: white;
            padding: 12px 30px;
            border-radius: 15px;
            border: none;
            font-size: 18px;
            transition: all 0.3s ease;
            margin-top: 20px;
            width: 100%;
            max-width: 300px;
        }
        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            opacity: 0.9;
        }
        .animate-card {
            animation: fadeInUp 1s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="status-card animate-card">
            <div class="icon-container animate__animated animate__bounceIn">
                <img src="<?php echo $iconPath; ?>" alt="Status Icon">
            </div>
            <div class="message animate__animated animate__fadeIn">
                <?php echo $message; ?>
            </div>
            <button onclick="window.history.back()" class="btn-back animate__animated animate__fadeIn">
                Kembali ke Halaman Sebelumnya
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>