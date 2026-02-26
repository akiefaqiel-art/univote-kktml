<?php
session_start();
include 'db.php';

// Semak akses admin
if (!isset($_SESSION['user_id']) || $_SESSION['email'] != 'admin@student.ledang.edu.my') {
    echo "<script>alert('Anda tidak mempunyai akses admin!'); window.location='dashboard.php';</script>";
    exit();
}

// Ambil jumlah pelajar yang dah selesai mengundi
$res_undi = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE status_undi = 1");
$data_undi = mysqli_fetch_assoc($res_undi);

// Ambil jumlah keseluruhan pelajar dalam sistem
$res_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$data_total = mysqli_fetch_assoc($res_total);

// Kira peratusan (elakkan ralat bahagi dengan kosong)
$total_pelajar = $data_total['total'] > 0 ? $data_total['total'] : 1;
$peratus = ($data_undi['total'] / $total_pelajar) * 100;
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Admin Dashboard | Uni-Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <h2 class="fw-bold text-center mb-4"><i class="fas fa-chart-line text-primary me-2"></i>Statistik Pengundian Semasa</h2>
                        
                        <div class="text-center mb-3">
                            <span class="display-4 fw-bold text-primary"><?php echo number_format($peratus, 1); ?>%</span>
                            <p class="text-muted">Pelajar Telah Mengundi</p>
                        </div>

                        <div class="progress mb-4" style="height: 35px; border-radius: 10px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" 
                                 role="progressbar" style="width: <?php echo $peratus; ?>%">
                                 <?php echo $data_undi['total']; ?> / <?php echo $data_total['total']; ?> Pelajar
                            </div>
                        </div>
<div class="row mt-4 justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0" style="border-radius: 20px; background: rgba(255,255,255,0.8);">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-4"><i class="fas fa-chart-pie me-2 text-primary"></i>Taburan Undi Calon</h5>
                <div style="max-width: 400px; margin: auto;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Ambil data dinamik dari database guna PHP
    <?php
    $query_graf = mysqli_query($conn, "SELECT nama_calon, jumlah_undi FROM calon");
    $label_calon = [];
    $data_undi = [];

    while($row = mysqli_fetch_assoc($query_graf)) {
        $label_calon[] = $row['nama_calon'];
        $data_undi[] = $row['jumlah_undi'];
    }
    ?>

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie', // Gunakan carta pai (pie chart)
        data: {
            labels: <?php echo json_encode($label_calon); ?>,
            datasets: [{
                data: <?php echo json_encode($data_undi); ?>,
                backgroundColor: ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#fd7e14', '#ffc107'],
                borderWidth: 2,
                hoverOffset: 15
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
                        <div class="row text-center mt-5">
                            <div class="col-6">
                                <a href="keputusan.php" class="btn btn-outline-primary w-100 p-3 rounded-pill fw-bold">
                                    <i class="fas fa-poll me-2"></i>Lihat Keputusan
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="dashboard.php" class="btn btn-primary w-100 p-3 rounded-pill fw-bold">
                                    <i class="fas fa-home me-2"></i>Ke Dashboard
                                </a>
                            </div>
                        </div>
                    <div class="row mt-3 text-center">
    <div class="col-12">
        <a href="cetak_keputusan.php" class="btn btn-danger w-100 p-3 rounded-pill fw-bold shadow-sm">
            <i class="fa-solid fa-file-pdf me-2"></i>JANA LAPORAN KEPUTUSAN (PDF)
        </a>
    </div>
</div></div>
                </div>
                <p class="text-center text-muted mt-4">Sistem Uni-Vote &copy; 2026</p>
            </div>
        </div>
    </div>
</body>
</html>