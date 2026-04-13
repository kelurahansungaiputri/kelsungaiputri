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
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

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

if ($conn->query($table_sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

?>
