<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$type = $_GET['type'] ?? '';
$jenis_layanan = [
    'konseling_individu' => 'Konseling Individu',
    'konseling_kelompok' => 'Konseling Kelompok',
    'bimbingan_kelompok' => 'Bimbingan Kelompok',
    'bimbingan_klasikal' => 'Bimbingan Klasikal',
    'kolaborasi' => 'Kolaborasi',
    'mediasi' => 'Mediasi',
    'konsultasi' => 'Konsultasi',
    'home_visit' => 'Kunjungan Rumah'
];

if (!array_key_exists($type, $jenis_layanan)) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form <?php echo $jenis_layanan[$type]; ?> - Sistem Rekam Jejak BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="mb-4">Form <?php echo $jenis_layanan[$type]; ?></h2>
        
        <div class="card">
            <div class="card-body">
                <form action="../config/save_layanan.php" method="POST">
                    <input type="hidden" name="jenis_layanan" value="<?php echo $type; ?>">
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>

                    <?php if (in_array($type, ['konseling_kelompok', 'bimbingan_kelompok'])): ?>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa (Pisahkan dengan koma untuk multiple siswa)</label>
                        <textarea class="form-control" id="nama_siswa" name="nama_siswa" rows="3" required></textarea>
                    </div>
                    <?php else: ?>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>

                    <?php if ($type == 'home_visit'): ?>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="topik" class="form-label">Topik/Permasalahan</label>
                        <textarea class="form-control" id="topik" name="topik" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Layanan/Proses</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tindak_lanjut" class="form-label">Rencana Tindak Lanjut</label>
                        <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="selesai">Selesai</option>
                            <option value="berkelanjutan">Berkelanjutan</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>