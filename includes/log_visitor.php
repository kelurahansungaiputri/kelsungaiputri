<?php
// Include database configuration
include 'config/db.php';

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

// Check if this IP already visited today
$check_sql = "SELECT id FROM kunjungan WHERE ip_address = '$ip' AND tanggal = '$tanggal'";
$result = $conn->query($check_sql);

// Only log if IP hasn't visited today yet
if ($result->num_rows == 0) {
    $sql = "INSERT INTO kunjungan (ip_address, tanggal, jam) VALUES ('$ip', '$tanggal', '$jam')";
    if (!$conn->query($sql)) {
        // Silently fail - don't disrupt page load
    }
}

$conn->close();
?>
