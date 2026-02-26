<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Check format emel ledang
    if (strpos($email, '@student.ledang.edu.my') !== false) {
        
        // 2. Check user dalam database
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
        
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            
            // Simpan session (Data ni penting untuk page seterusnya)
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['nama'] = $data['nama_penuh']; 
            $_SESSION['email'] = $data['email']; 
            $_SESSION['status_undi'] = $data['status_undi'];
            
            // LOGIK PENGASINGAN ADMIN & STUDENT
if ($data['email'] == 'admin@student.ledang.edu.my') {
    // Kalau email admin yang masuk, hantar ke dashboard admin
    echo "<script>alert('Berjaya Log Masuk sebagai Admin!'); window.location='admin_dashboard.php';</script>";
} else {
    // Kalau email lain (student), hantar ke page mengundi biasa
    echo "<script>alert('Berjaya Log Masuk!'); window.location='dashboard.php';</script>";
}
        } else {
            echo "<script>alert('Emel atau Password salah!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Sila guna emel rasmi @student.ledang.edu.my sahaja!'); window.location='index.php';</script>";
    }
}
?>