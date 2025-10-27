<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/database.php';

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan - Sistem Rekam Jejak BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Sistem Rekam Jejak BK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Kembali ke Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Rekap Laporan Kegiatan</h2>
            <button onclick="exportToExcel()" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export ke Excel
            </button>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Layanan</label>
                        <select class="form-select" name="jenis_layanan">
                            <option value="">Semua Layanan</option>
                            <option value="konseling_individu" <?php echo $jenis_layanan == 'konseling_individu' ? 'selected' : ''; ?>>Konseling Individu</option>
                            <option value="konseling_kelompok" <?php echo $jenis_layanan == 'konseling_kelompok' ? 'selected' : ''; ?>>Konseling Kelompok</option>
                            <option value="bimbingan_kelompok" <?php echo $jenis_layanan == 'bimbingan_kelompok' ? 'selected' : ''; ?>>Bimbingan Kelompok</option>
                            <option value="bimbingan_klasikal" <?php echo $jenis_layanan == 'bimbingan_klasikal' ? 'selected' : ''; ?>>Bimbingan Klasikal</option>
                            <option value="kolaborasi" <?php echo $jenis_layanan == 'kolaborasi' ? 'selected' : ''; ?>>Kolaborasi</option>
                            <option value="mediasi" <?php echo $jenis_layanan == 'mediasi' ? 'selected' : ''; ?>>Mediasi</option>
                            <option value="konsultasi" <?php echo $jenis_layanan == 'konsultasi' ? 'selected' : ''; ?>>Konsultasi</option>
                            <option value="home_visit" <?php echo $jenis_layanan == 'home_visit' ? 'selected' : ''; ?>>Kunjungan Rumah</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Layanan</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Topik</th>
                        <th>Status</th>
                        <th>Konselor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)): 
                        $jenis = str_replace('_', ' ', $row['jenis_layanan']);
                        $jenis = ucwords($jenis);
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo $jenis; ?></td>
                        <td><?php echo $row['nama_siswa']; ?></td>
                        <td><?php echo $row['kelas']; ?></td>
                        <td><?php echo $row['topik']; ?></td>
                        <td>
                            <span class="badge <?php echo $row['status'] == 'selesai' ? 'bg-success' : 'bg-warning'; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td><?php echo $row['nama_konselor']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewDetail(<?php echo $row['id']; ?>)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewDetail(id) {
            fetch(`get_detail.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalContent').innerHTML = data;
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                });
        }

        function exportToExcel() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            let exportUrl = 'export_excel.php';
            
            // Add filters to export URL if they exist
            if (urlParams.toString()) {
                exportUrl += '?' + urlParams.toString();
            }
            
            window.location.href = exportUrl;
        }
    </script>
</body>
</html>