<?php
include 'db.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penuh']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check kalau emel dah wujud
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Emel ini sudah berdaftar!');</script>";
    } else {
        // Masukkan data baru (Status asal: Belum Mengundi)
        $query = "INSERT INTO users (nama_penuh, email, password, status_undi) VALUES ('$nama', '$email', '$password', '0')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran Berjaya! Sila Log Masuk.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akaun - Uni-Vote KKTML</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://source.unsplash.com/1600x900/?university,library');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            color: white;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 12px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: #ddd;
        }
        .btn-register {
            background: #0d6efd;
            border: none;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-register:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 register-container">
            <div class="text-center mb-4">
                <i class="fas fa-user-plus fa-3x mb-3"></i>
                <h2 class="fw-bold">Daftar Pengundi</h2>
                <p class="text-white-50">Sila isi maklumat anda untuk mula mengundi</p>
            </div>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-2"></i>Nama Penuh</label>
                    <input type="text" name="nama_penuh" class="form-control" placeholder="Contoh: MUHAMMAD ALI" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope me-2"></i>Emel Pelajar</label>
                    <input type="email" name="email" class="form-control" placeholder="ID@student.ledang.edu.my" required>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-lock me-2"></i>Kata Laluan</label>
                    <input type="password" name="password" class="form-control" placeholder="Cipta kata laluan" required>
                </div>

                <button type="submit" name="register" class="btn btn-primary btn-register w-100 mb-3">
                    DAFTAR SEKARANG
                </button>
                
                <div class="text-center">
                    <p class="mb-0">Dah ada akaun? <a href="index.php" class="text-info fw-bold text-decoration-none">Log Masuk</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>