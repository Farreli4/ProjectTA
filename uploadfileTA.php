
session_start();
$nama_mahasiswa = $_SESSION['nama'] ?? 'Mahasiswa'; // Default jika tidak ada session
$nim = $_SESSION['nim'] ?? '12345678';

// Proses upload file jika ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $file = $_FILES['file_upload'];
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileCategory = $_POST['file_type'] ?? '';
    
    // Format nama file
    $newFileName = $nim . '_' . str_replace(' ', '_', $fileCategory) . '_' . $nama_mahasiswa . '.' . $fileType;
    
    // Validasi file
    if ($fileType != "pdf") {
        echo "<script>alert('Maaf, hanya file PDF yang diperbolehkan.');</script>";
    } elseif ($file['size'] > 2000000) { // 2MB
        echo "<script>alert('Maaf, ukuran file terlalu besar (max 2MB).');</script>";
    } else {
        try {
            // Koneksi ke database
            $conn = new PDO("mysql:host=localhost;dbname=sistemta", "root", "");
            $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Baca file sebagai binary
            $fileContent = file_get_contents($file['tmp_name']);
            
            // Tentukan nama tabel berdasarkan tipe file
            $tableName = '';
            switch($fileCategory) {
                case 'Form Pendaftaran dan Persetujuan Tema':
                    $tableName = 'form_pendaftaran_persetujuan_tema_ta';
                    break;
                case 'Bukti Pembayaran':
                    $tableName = 'bukti_pembayaran_ta';
                    break;
                case 'Bukti Transkrip Nilai':
                    $tableName = 'bukti_transkip_nilai_ta';
                    break;
                case 'Bukti Kelulusan Mata kuliah Magang / PI':
                    $tableName = 'bukti_kelulusan_magang_ta';
                    break;
            }
            
            // Query untuk menyimpan file ke database
            $sql = "INSERT INTO mahasiswa ($tableName, status) 
                    VALUES ('Pending')";
            
            $stmt = $conn2->prepare($sql);
            $stmt->execute([
                ':nim' => $nim,
                ':nama_file' => $newFileName,
                ':file_content' => $fileContent
            ]);
            
            echo "<script>alert('File berhasil diupload.');</script>";
            
        } catch(PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}