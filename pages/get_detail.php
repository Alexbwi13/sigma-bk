<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    exit('Unauthorized');
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT l.*, u.nama as nama_konselor 
          FROM layanan_bk l 
          LEFT JOIN users u ON l.created_by = u.id 
          WHERE l.id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    exit('Data not found');
}

$jenis = str_replace('_', ' ', $data['jenis_layanan']);
$jenis = ucwords($jenis);
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th width="200">Jenis Layanan</th>
            <td><?php echo $jenis; ?></td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td><?php echo date('d/m/Y', strtotime($data['tanggal'])); ?></td>
        </tr>
        <tr>
            <th>Nama Siswa</th>
            <td><?php echo $data['nama_siswa']; ?></td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td><?php echo $data['kelas']; ?></td>
        </tr>
        <?php if ($data['jenis_layanan'] == 'home_visit'): ?>
        <tr>
            <th>Alamat</th>
            <td><?php echo $data['alamat']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th>Topik/Permasalahan</th>
            <td><?php echo nl2br($data['topik']); ?></td>
        </tr>
        <tr>
            <th>Deskripsi Layanan</th>
            <td><?php echo nl2br($data['deskripsi']); ?></td>
        </tr>
        <tr>
            <th>Tindak Lanjut</th>
            <td><?php echo nl2br($data['tindak_lanjut']); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge <?php echo $data['status'] == 'selesai' ? 'bg-success' : 'bg-warning'; ?>">
                    <?php echo ucfirst($data['status']); ?>
                </span>
            </td>
        </tr>
        <tr>
            <th>Konselor</th>
            <td><?php echo $data['nama_konselor']; ?></td>
        </tr>
    </table>
</div>