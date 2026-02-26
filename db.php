<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_OFF);

$host = getenv('MYSQLHOST') ?: getenv('MYSQL_HOST') ?: "localhost";
$user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: "";
$db   = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: "univote_db";
$port = getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: "3306";

// Optional: Kalau Railway guna MYSQL_URL terus
$mysql_url = getenv('MYSQL_URL');
if ($mysql_url) {
    $db_parts = parse_url($mysql_url);
    $host = $db_parts['host'];
    $user = $db_parts['user'];
    $pass = $db_parts['pass'];
    $db   = ltrim($db_parts['path'], '/');
    $port = $db_parts['port'];
}

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Gagal sambung database: " . mysqli_connect_error());
}
?>