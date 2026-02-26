<?php
session_start();
include 'db.php';

// Pastikan user dah login, kalau tak tendang balik
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Redirect kalau dah mengundi
$user_id = $_SESSION['user_id'];
$check_status = mysqli_query($conn, "SELECT status_undi FROM users WHERE id = '$user_id'");
if ($check_status) {
    $user_data = mysqli_fetch_assoc($check_status);
    if ($user_data['status_undi'] == '1' || $user_data['status_undi'] == 'Sudah Mengundi') {
        header("Location: resit.php");
        exit();
    }
}

$query = mysqli_query($conn, "SELECT * FROM calon");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Uni-Vote | Pilihan Raya Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            padding-bottom: 100px;
            min-height: 100vh;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .card { border-radius: 15px; border: none; transition: 0.3s; }
        .selected-card { border: 3px solid #28a745 !important; background: #e8f5e9; }
        .sticky-footer { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(33, 37, 41, 0.9); backdrop-filter: blur(10px); z-index: 1000; }
        /* Efek apabila mouse lalu atas kad calon */
    .card {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
    }

    /* Efek glow hijau apabila kad dipilih */
    .selected-card {
        border: 3px solid #28a745 !important;
        background: #e8f5e9 !important;
        box-shadow: 0 0 20px rgba(40, 167, 69, 0.4) !important;
    }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-transparent p-3">
    <div class="container">
        <span class="navbar-brand fw-bold">Uni-Vote</span>
        <span class="text-white">Hai, <?php echo $_SESSION['nama']; ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Log Keluar</a>
    </div>
</nav>

<div class="container mt-4 text-center text-white mb-5">
    <h1 class="fw-bold">Pilih Perwakilan Anda</h1>
    <p>Sila pilih maksimum 10 calon.</p>
<div class="container mb-4">
    <div class="progress" style="height: 30px; border-radius: 15px; background-color: rgba(255,255,255,0.2);">
        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
             role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
             0/10 Calon Dipilih
        </div>
    </div>
</div></div>

<div class="container">
    <form action="proses_undi.php" method="POST" id="formUndi">
        <div class="row">
            <?php while($row = mysqli_fetch_assoc($query)) { ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow" id="card-<?php echo $row['id']; ?>">
                    <div class="card-body text-center">
                        <i class="fas fa-user-graduate fa-3x mb-3 text-muted"></i>
                        <h5 class="fw-bold"><?php echo $row['nama_calon']; ?></h5>
                        <p class="small text-primary text-uppercase"><?php echo $row['fakulti']; ?></p>
                        <p class="small fst-italic">"<?php echo $row['manifesto']; ?>"</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <input type="checkbox" class="btn-check calon-check" name="calon_pilihan[]" 
                               value="<?php echo $row['id']; ?>" id="btn-<?php echo $row['id']; ?>" autocomplete="off" 
                               onclick="toggleCard(<?php echo $row['id']; ?>)">
                        <label class="btn btn-outline-primary w-100 rounded-pill" for="btn-<?php echo $row['id']; ?>">PILIH SAYA</label>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="sticky-footer p-3 text-white">
            <div class="container d-flex justify-content-between align-items-center">
                <h4>Pilihan: <span id="count" class="badge bg-warning text-dark">0</span> / 10</h4>
                <button type="button" class="btn btn-success btn-lg px-5 rounded-pill" id="btnUndi" disabled onclick="confirmVote()">HANTAR UNDI <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleCard(id) {
        const checkbox = document.getElementById('btn-' + id);
        const card = document.getElementById('card-' + id);
        if (checkbox.checked) {
            card.classList.add('selected-card');
        } else {
            card.classList.remove('selected-card');
        }
        updateCount();
    }

    function updateCount() {
        const checkboxes = document.querySelectorAll('.calon-check:checked');
        const countSpan = document.getElementById('count');
        const btnUndi = document.getElementById('btnUndi');
        let total = checkboxes.length;

        if (total > 10) {
            Swal.fire('Had Tercapai!', 'Maksimum 10 calon sahaja.', 'error');
            event.target.checked = false;
            document.getElementById('card-' + event.target.value).classList.remove('selected-card');
            total = 10;
        }
        countSpan.innerText = total;
        // Kod gerakkan Progress Bar
        const progressBar = document.getElementById('progressBar');
        let percentage = (total / 10) * 100;
        progressBar.style.width = percentage + '%';
        progressBar.innerText = total + '/10 Calon Dipilih';

        // Tukar warna bar
        if (total === 10) {
            progressBar.classList.remove('bg-success');
            progressBar.classList.add('bg-warning', 'text-dark');
        } else {
            progressBar.classList.add('bg-success');
            progressBar.classList.remove('bg-warning', 'text-dark');
        }
        btnUndi.disabled = (total === 0 || total > 10);
    }

    function confirmVote() {
        Swal.fire({
            title: 'Hantar undian?',
            text: "Tindakan ini tidak boleh diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hantar!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formUndi').submit();
            }
        });
    }
</script>
</body>
<div id="loader" style="position: fixed; width: 100%; height: 100vh; background: white; z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
    <p class="mt-3 fw-bold text-primary">Memuatkan Calon...</p>
</div>

<script>
    // Hilangkan loader lepas 1 saat
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
        }, 1000);
    });
</script>
</html>