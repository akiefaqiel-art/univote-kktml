<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Login | E-Undi KKTM Ledang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* 1. BACKGROUND GEMPAK (Gambar Kampus) */
        body {
            /* Kalau nak tukar gambar sendiri, ganti URL dalam kurungan ni */
            background: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        /* 2. OVERLAY GELAP (Supaya tulisan nampak jelas) */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 24, 69, 0.85), rgba(0, 0, 0, 0.7));
            z-index: 1;
        }

        /* 3. CONTAINER CONTENT */
        .login-container {
            z-index: 2; /* Duduk atas overlay */
            width: 100%;
            max-width: 420px;
            padding: 20px;
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }

        /* 4. LOGO & TAJUK */
        .brand-title {
            color: #fff;
            font-weight: 800;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.5);
            margin-bottom: 5px;
        }

        .brand-subtitle {
            color: #dbeafe;
            font-size: 1.1rem;
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* 5. KAD LOGIN GLASSMORPHISM */
        .card-login {
            background: rgba(255, 255, 255, 0.15); /* Lutsinar */
            backdrop-filter: blur(15px); /* Effect kabur belakang */
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        /* Input Styles */
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50px; /* Bentuk bulat */
            padding: 12px 20px;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
        }

        /* Butang Masuk */
        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            background: #0d6efd;
            border: none;
            font-weight: bold;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
            background: #0b5ed7;
        }

        /* Footer Kecil */
        .footer-text {
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
        }

        /* Animasi Masuk */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="login-container">
        <div class="mb-3">
            <i class="fas fa-university fa-3x text-white"></i>
        </div>

        <h1 class="brand-title">KKTM LEDANG</h1>
        <p class="brand-subtitle">Sistem E-Undi Majlis Perwakilan Pelajar</p>

        <div class="card-login">
            <form action="proses_login.php" method="POST">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="✉️  Emel Pelajar (@student.ledang.edu.my)" required>
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password" class="form-control" placeholder="🔒  Kata Laluan" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-login">
                    LOG MASUK <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>
            <div class="text-center mt-3">
    <p class="text-white-50">Pengundi Baru? <a href="register.php" class="text-white fw-bold">Daftar Akaun di sini</a></p>
</div>
        </div>

        <div class="footer-text">
            &copy; 2026 Unit Hal Ehwal Pelajar KKTM Ledang
        </div>
    </div>

</body>
</html>