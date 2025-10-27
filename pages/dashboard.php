<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Rekam Jejak BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .service-card {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Sistem Rekam Jejak BK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Selamat datang, <?php echo $_SESSION['nama'] ?? $_SESSION['username']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../config/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row g-4">
            <!-- Layanan Konseling Individu -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-circle fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Konseling Individu</h5>
                        <a href="form_layanan.php?type=konseling_individu" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Konseling Kelompok -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Konseling Kelompok</h5>
                        <a href="form_layanan.php?type=konseling_kelompok" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Bimbingan Kelompok -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-collection fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Bimbingan Kelompok</h5>
                        <a href="form_layanan.php?type=bimbingan_kelompok" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Bimbingan Klasikal -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-easel fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Bimbingan Klasikal</h5>
                        <a href="form_layanan.php?type=bimbingan_klasikal" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Kolaborasi -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-diagram-3 fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Kolaborasi</h5>
                        <a href="form_layanan.php?type=kolaborasi" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Mediasi -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Mediasi</h5>
                        <a href="form_layanan.php?type=mediasi" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Konsultasi -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-chat-dots fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Konsultasi</h5>
                        <a href="form_layanan.php?type=konsultasi" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>

            <!-- Layanan Home Visit -->
            <div class="col-md-3">
                <div class="card service-card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-house fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Kunjungan Rumah</h5>
                        <a href="form_layanan.php?type=home_visit" class="btn btn-primary mt-2">Input Data</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Laporan Button -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Rekap Laporan Kegiatan</h5>
                        <a href="rekap_laporan.php" class="btn btn-lg btn-primary mt-2">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>