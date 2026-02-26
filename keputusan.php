<?php
include 'db.php';

// Kita tarik data untuk jadual
$query = mysqli_query($conn, "SELECT * FROM calon ORDER BY jumlah_undi DESC");

// Kita tarik data sekali lagi khas untuk CARTA (Chart)
$chartQuery = mysqli_query($conn, "SELECT * FROM calon");
$nama_calon = [];
$jumlah_undi = [];

while($data = mysqli_fetch_assoc($chartQuery)) {
    $nama_calon[] = $data['nama_calon'];
    $jumlah_undi[] = $data['jumlah_undi'];
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Live Result | Uni-Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-chart {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
        }
        .card-table {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }
        .header-title {
            background: linear-gradient(90deg, #0d6efd, #0dcaf0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
    </style>
    
    <meta http-equiv="refresh" content="5">
</head>
<body class="py-5">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="header-title display-4">KEPUTUSAN RASMI</h1>
            <p class="text-muted">Statistik undian terkini secara langsung</p>
        </div>
        <a href="index.php" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fas fa-home me-2"></i>Ke Halaman Utama
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card card-chart p-4 h-100">
                <h4 class="fw-bold mb-4 text-secondary"><i class="fas fa-chart-bar me-2"></i>Carta Analitik Undian</h4>
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-chart p-4 h-100">
                <h4 class="fw-bold mb-4 text-secondary"><i class="fas fa-trophy me-2 text-warning"></i>Top 5 Mendahului</h4>
                
                <div class="list-group list-group-flush">
                    <?php 
                    $rank = 1;
                    // Reset pointer query untuk table
                    mysqli_data_seek($query, 0); 
                    while($row = mysqli_fetch_assoc($query)) { 
                        if($rank > 5) break; // Tunjuk Top 5 je kat sini
                        
                        $icon = ($rank == 1) ? "🥇" : (($rank == 2) ? "🥈" : (($rank == 3) ? "🥉" : "#".$rank));
                        $bg_class = ($rank == 1) ? "bg-warning-subtle border-warning" : "bg-light";
                    ?>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-center mb-2 rounded <?php echo $bg_class; ?>">
                        <div class="d-flex align-items-center">
                            <span class="fs-4 me-3"><?php echo $icon; ?></span>
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo $row['nama_calon']; ?></h6>
                                <small class="text-muted"><?php echo $row['fakulti']; ?></small>
                            </div>
                        </div>
                        <span class="badge bg-primary rounded-pill fs-6"><?php echo $row['jumlah_undi']; ?></span>
                    </div>

                    <?php $rank++; } ?>
                </div>

                <div class="mt-auto text-center pt-3">
                    <button class="btn btn-sm btn-light text-muted" data-bs-toggle="modal" data-bs-target="#fullTableModal">Lihat Senarai Penuh</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fullTableModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Senarai Penuh Undian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr><th>Nama</th><th>Fakulti</th><th>Undi</th></tr>
            </thead>
            <tbody>
                <?php 
                mysqli_data_seek($query, 0);
                while($full = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td><?php echo $full['nama_calon']; ?></td>
                    <td><?php echo $full['fakulti']; ?></td>
                    <td><?php echo $full['jumlah_undi']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
    // Ambil data dari PHP masuk ke JS
    const labelCalon = <?php echo json_encode($nama_calon); ?>;
    const dataUndi = <?php echo json_encode($jumlah_undi); ?>;

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar', // Boleh tukar jadi 'pie' atau 'line' kalau nak
        data: {
            labels: labelCalon,
            datasets: [{
                label: 'Jumlah Undian',
                data: dataUndi,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Supaya takde nombor perpuluhan (0.5 undi)
                    }
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>