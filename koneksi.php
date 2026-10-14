<?php
$host     = "localhost";
$dbname   = "db_laporan_fasilitas";
$user     = "root";
$pass     = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
        PDO::ATTR_EMULATE_PREPARES   => false,                
    ]);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

$pesan_sukses = "";
$pesan_error  = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelapor   = trim($_POST['nama_pelapor'] ?? '');
    $nama_fasilitas = trim($_POST['nama_fasilitas'] ?? '');
    $lokasi         = trim($_POST['lokasi'] ?? '');
    $id_kategori    = (int)($_POST['id_kategori'] ?? 0);
    $deskripsi      = trim($_POST['deskripsi'] ?? '');
    $prioritas      = $_POST['prioritas'] ?? '';

    if (!empty($nama_pelapor) && !empty($nama_fasilitas) && !empty($lokasi) && $id_kategori > 0 && !empty($deskripsi) && !empty($prioritas)) {
        try {
            $sql = "INSERT INTO laporan_kerusakan 
                    (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas, status, tanggal_laporan) 
                    VALUES (:nama_pelapor, :nama_fasilitas, :lokasi, :id_kategori, :deskripsi, :prioritas, 'Menunggu', NOW())";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nama_pelapor'   => $nama_pelapor,
                ':nama_fasilitas' => $nama_fasilitas,
                ':lokasi'         => $lokasi,
                ':id_kategori'    => $id_kategori,
                ':deskripsi'      => $deskripsi,
                ':prioritas'      => $prioritas
            ]);

            $pesan_sukses = "Laporan berhasil dikirim dan tersimpan!";
        } catch (PDOException $e) {
            $pesan_error = "Gagal menyimpan laporan: " . $e->getMessage();
        }
    } else {
        $pesan_error = "Mohon isi semua bidang formulir dengan benar.";
    }
}
try {
    $stmt_kategori = $pdo->query("SELECT * FROM kategori_fasilitas ORDER BY nama_kategori ASC");
    $list_kategori = $stmt_kategori->fetchAll();
} catch (PDOException $e) {
    $list_kategori = [];
}
try {
    $sql_laporan = "SELECT l.*, k.nama_kategori 
                    FROM laporan_kerusakan l 
                    JOIN kategori_fasilitas k ON l.id_kategori = k.id_kategori 
                    ORDER BY l.tanggal_laporan DESC";
    $stmt_laporan = $pdo->query($sql_laporan);
    $list_laporan = $stmt_laporan->fetchAll();
} catch (PDOException $e) {
    $list_laporan = [];
}
?>