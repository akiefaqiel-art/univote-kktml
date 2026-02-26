<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_OFF);

$host = getenv('MYSQLHOST') ?: "localhost";
$user = getenv('MYSQLUSER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "";
$db   = getenv('MYSQLDATABASE') ?: "univote_db";
$port = getenv('MYSQLPORT') ?: "3306";

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Gagal sambung database: " . mysqli_connect_error());
}
?>