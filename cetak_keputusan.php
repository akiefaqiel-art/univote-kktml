<?php
session_start();
include 'db.php';

// Semak akses admin
if (!isset($_SESSION['user_id']) || $_SESSION['email'] != 'admin@student.ledang.edu.my') {
    echo "<script>alert('Anda tidak mempunyai akses admin!'); window.location='index.php';</script>";
    exit();
}

// Ambil data keputusan dari database
$result = mysqli_query($conn, "SELECT * FROM calon ORDER BY jumlah_undi DESC");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rasmi Keputusan Undian - Uni-Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: white; font-family: Arial, sans-serif; }
        .header-laporan { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 30px; }
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="text-center header-laporan">
        <h2 class="fw-bold text-uppercase">Kolej Kemahiran Tinggi MARA Ledang</h2>
        <h4>Laporan Rasmi Keputusan Majlis Perwakilan Pelajar</h4>
        <p class="mb-0 text-muted">Tarikh Laporan: <?php echo date('d-m-Y H:i A'); ?></p>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Kedudukan</th>
                <th>Nama Calon</th>
                <th>Jabatan/Kursus</th>
                <th>Jumlah Undi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="text-center">
                <td><?php echo $no++; ?></td>
                <td class="text-start"><?php echo $row['nama_calon']; ?></td>
                <td><?php echo $row['jabatan']; ?></td>
                <td class="fw-bold"><?php echo $row['jumlah_undi']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Disahkan oleh,</p>
            <br><br>
            <p>_______________________<br><strong>Pegawai Hal Ehwal Pelajar</strong></p>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg"><i class="fas fa-print"></i> Cetak / Simpan sebagai PDF</button>
        <a href="admin_dashboard.php" class="btn btn-secondary btn-lg">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>