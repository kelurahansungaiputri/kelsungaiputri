<?php
// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sungaiputri_kunjungan";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    // Silently fail if database not available
    exit;
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select database
$conn->select_db($dbname);

// Create visitors table if not exists
$table_sql = "CREATE TABLE IF NOT EXISTS kunjungan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50),
    tanggal DATE,
    jam TIME,
    waktu_kunjung TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($table_sql);

// Get visitor IP address
$ip = "";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// Get current date and time
$tanggal = date('Y-m-d');
$jam = date('H:i:s');

// Escape IP for safety
$ip = $conn->real_escape_string($ip);

// Check if this IP already visited today
$check_sql = "SELECT id FROM kunjungan WHERE ip_address = '$ip' AND tanggal = '$tanggal'";
$result = $conn->query($check_sql);

// Only log if IP hasn't visited today yet
if ($result && $result->num_rows == 0) {
    $sql = "INSERT INTO kunjungan (ip_address, tanggal, jam) VALUES ('$ip', '$tanggal', '$jam')";
    $conn->query($sql);
}

// Store connection for later use
$GLOBALS['db_conn'] = $conn;
?>
