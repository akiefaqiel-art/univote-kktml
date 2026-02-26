<?php
session_start();
include 'db.php';

// Pastikan user dah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Pastikan butang undi ditekan
if (isset($_POST['calon_pilihan'])) {
    $user_id = $_SESSION['user_id'];
    
    // Semak jika pelajar sudah mengundi sebelum ini
    $check_status = mysqli_query($conn, "SELECT status_undi FROM users WHERE id = '$user_id'");
    if ($check_status) {
        $user_data = mysqli_fetch_assoc($check_status);
        if ($user_data['status_undi'] == '1' || $user_data['status_undi'] == 'Sudah Mengundi') {
            echo "<script>alert('Anda telah pun mengundi! Tidak boleh mengundi dua kali.'); window.location='terima_kasih.php';</script>";
            exit();
        }
    }

    $pilihan = $_POST['calon_pilihan'];

    // 2. Polis: Halang jika lebih 10 calon
    if (count($pilihan) > 10) {
        echo "<script>alert('Ralat: Maksimum 10 calon sahaja!'); window.location='dashboard.php';</script>";
        exit();
    }

    // 3. Masukkan undi ke database
    foreach ($pilihan as $id_calon) {
        $id_calon = (int)$id_calon; // Prevent SQL Injection
        mysqli_query($conn, "UPDATE calon SET jumlah_undi = jumlah_undi + 1 WHERE id = '$id_calon'");
    }

    // 4. Kunci akaun supaya tidak boleh undi lagi
    mysqli_query($conn, "UPDATE users SET status_undi = '1' WHERE id = '$user_id'");
    $_SESSION['status_undi'] = '1';

    // 5. Selesai! Hantar ke page terima kasih (mercun kertas)
    echo "<script>alert('Undian berjaya disimpan! Sila simpan resit anda.'); window.location='resit.php';</script>";
    exit();
} else {
    // Jika hantar tanpa pilih sesiapa
    echo "<script>alert('Sila pilih sekurang-kurangnya 1 calon!'); window.location='dashboard.php';</script>";
}
?>