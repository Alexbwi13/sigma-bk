<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_layanan = mysqli_real_escape_string($conn, $_POST['jenis_layanan']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $nama_siswa = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $topik = mysqli_real_escape_string($conn, $_POST['topik']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tindak_lanjut = mysqli_real_escape_string($conn, $_POST['tindak_lanjut']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';
    $created_by = $_SESSION['user_id'];

    $query = "INSERT INTO layanan_bk (jenis_layanan, tanggal, nama_siswa, kelas, topik, deskripsi, 
              tindak_lanjut, status, alamat, created_by) 
              VALUES ('$jenis_layanan', '$tanggal', '$nama_siswa', '$kelas', '$topik', '$deskripsi', 
              '$tindak_lanjut', '$status', '$alamat', $created_by)";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/dashboard.php?success=1");
        exit();
    } else {
        header("Location: ../pages/form_layanan.php?type=$jenis_layanan&error=1");
        exit();
    }
}
?>