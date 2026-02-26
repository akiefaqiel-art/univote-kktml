<?php
session_start();
include 'db.php';
include 'phpqrcode/qrlib.php'; 

// Kalau belum login, tendang balik ke muka depan
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit;
}

// Ambil maklumat student dari session
$nama = $_SESSION['nama'] ?? 'Pelajar KKTML';
$email = $_SESSION['email'] ?? 'Tiada Rekod'; 
$masa = date('d-m-Y h:i A'); // Rekod masa undi (Format 12-Jam)

// 1. Ini teks yang akan dibaca kalau panel scan guna phone
$data_qr = "BUKTI UNDIAN SAH\nNama: $nama\nEmail: $email\nMasa: $masa\nSistem: Uni-Vote KKTML";

// 2. Arahkan sistem jana gambar QR secara langsung guna Output Buffering
ob_start();
QRcode::png($data_qr, null, QR_ECLEVEL_L, 5, 2); // Simpan terus tanpa fail
$imageString = base64_encode(ob_get_contents());
ob_end_clean();

// 3. Formatkan gambar tersebut supaya boleh dipaparkan guna HTML
$laluan_gambar = 'data:image/png;base64,' . $imageString;
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resit Rasmi - Uni-Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Tambahan untuk kasi lawa */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .receipt-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            border: none;
        }
        .receipt-header {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        .receipt-body {
            padding: 30px;
            text-align: center;
        }
        .qr-wrapper {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            display: inline-block;
            border: 2px dashed #dee2e6;
            margin-bottom: 25px;
        }
        /* Sorok butang bila student tekan Print/Save PDF */
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .receipt-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>

<div class="container px-3">
    <div class="card receipt-card mx-auto" style="max-width: 420px;">
        <div class="receipt-header">
            <h3 class="mb-1 fw-bold"><i class="fa-solid fa-circle-check me-2"></i>Undian Berjaya</h3>
            <span class="text-white-50" style="font-size: 0.9rem;">Sistem E-Undi KKTML</span>
        </div>
        
        <div class="receipt-body">
            <p class="text-muted mb-4" style="font-size: 0.95rem;">Terima kasih kerana menjalankan tanggungjawab anda sebagai pengundi.</p>
            
            <div class="qr-wrapper shadow-sm">
                <img src="<?php echo $laluan_gambar; ?>" alt="QR Code Resit" class="img-fluid" style="width: 180px; height: 180px;">
            </div>
            
            <h5 class="fw-bold text-dark mb-1"><?php echo $nama; ?></h5>
            <p class="mb-2 text-secondary"><i class="fa-solid fa-envelope me-2 text-muted"></i><?php echo $email; ?></p>
            
            <div class="bg-light rounded p-2 mb-4 mt-3 border border-light-subtle">
                <small class="text-muted d-block mb-1">Tarikh & Masa Undian Disahkan:</small>
                <span class="fw-bold text-dark"><i class="fa-regular fa-clock me-1"></i> <?php echo $masa; ?></span>
            </div>
            
            <p class="text-danger mb-4 text-start bg-danger-subtle p-2 rounded" style="font-size: 0.8rem;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i><strong>Penting:</strong> Sila simpan resit ini sebagai bukti sah jika berlaku sebarang ralat pada sistem.
            </p>
            
            <div class="d-grid gap-2 no-print">
                <button onclick="window.print()" class="btn btn-outline-secondary fw-bold shadow-sm">
                    <i class="fa-solid fa-print me-2"></i>Cetak / Simpan PDF
                </button>
                <a href="logout.php" class="btn btn-primary fw-bold shadow-sm">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Selesai & Log Keluar
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>