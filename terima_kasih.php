<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Terima Kasih! | Uni-Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }
        .success-card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            animation: popUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            max-width: 500px;
            width: 90%;
        }
        .icon-circle {
            width: 100px;
            height: 100px;
            background: #d1e7dd;
            color: #198754;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 3rem;
        }
        @keyframes popUp {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="icon-circle">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="fw-bold mb-3 text-dark">Tahniah!</h1>
        <p class="text-muted mb-4 lead">Undian anda telah berjaya direkodkan dalam sistem. Terima kasih kerana menjalankan tanggungjawab anda.</p>
        
        <div class="d-grid gap-2">
            <a href="keputusan.php" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                <i class="fas fa-chart-bar me-2"></i>Lihat Keputusan Terkini
            </a>
            <a href="logout.php" class="btn btn-outline-danger rounded-pill">
                Log Keluar
            </a>
        </div>
    </div>

    <script>
        // Tembak Confetti bila page loading!
        window.onload = function() {
            var duration = 3 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);
                // Tembak dari kiri dan kanan
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        };
    </script>

</body>
</html>