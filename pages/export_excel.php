<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    exit('Unauthorized');
}

// Build WHERE clause based on filters
$where = "1=1";
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$jenis_layanan = $_GET['jenis_layanan'] ?? '';

if ($start_date && $end_date) {
    $where .= " AND tanggal BETWEEN '$start_date' AND '$end_date'";
}

if ($jenis_layanan) {
    $where .= " AND jenis_layanan = '$jenis_layanan'";
}

$query = "SELECT l.*, u.nama as nama_konselor 
          FROM layanan_bk l 
          LEFT JOIN users u ON l.created_by = u.id 
          WHERE $where 
          ORDER BY l.tanggal DESC";
$result = mysqli_query($conn, $query);

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="rekap_layanan_bk.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Print Excel content
echo '<table border="1">';
echo '<tr>';
echo '<th>No</th>';
echo '<th>Tanggal</th>';
echo '<th>Jenis Layanan</th>';
echo '<th>Nama Siswa</th>';
echo '<th>Kelas</th>';
echo '<th>Topik</th>';
echo '<th>Deskripsi</th>';
echo '<th>Tindak Lanjut</th>';
echo '<th>Status</th>';
echo '<th>Konselor</th>';
if ($jenis_layanan == 'home_visit') {
    echo '<th>Alamat</th>';
}
echo '</tr>';

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $jenis = str_replace('_', ' ', $row['jenis_layanan']);
    $jenis = ucwords($jenis);
    
    echo '<tr>';
    echo '<td>' . $no++ . '</td>';
    echo '<td>' . date('d/m/Y', strtotime($row['tanggal'])) . '</td>';
    echo '<td>' . $jenis . '</td>';
    echo '<td>' . $row['nama_siswa'] . '</td>';
    echo '<td>' . $row['kelas'] . '</td>';
    echo '<td>' . $row['topik'] . '</td>';
    echo '<td>' . $row['deskripsi'] . '</td>';
    echo '<td>' . $row['tindak_lanjut'] . '</td>';
    echo '<td>' . ucfirst($row['status']) . '</td>';
    echo '<td>' . $row['nama_konselor'] . '</td>';
    if ($jenis_layanan == 'home_visit') {
        echo '<td>' . $row['alamat'] . '</td>';
    }
    echo '</tr>';
}

echo '</table>';