<?php
// Include database configuration
include 'config/db.php';

// Function to get visitor count for a specific date
function getVisitorCount($conn, $date) {
    $sql = "SELECT COUNT(DISTINCT ip_address) as count FROM kunjungan WHERE tanggal = '$date'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    return 0;
}

// Get dates
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$before = date('Y-m-d', strtotime('-2 day'));

// Get visitor counts
$count_today = getVisitorCount($conn, $today);
$count_yesterday = getVisitorCount($conn, $yesterday);
$count_before = getVisitorCount($conn, $before);

// Format dates in Indonesian
$hari_ini_label = "Hari Ini (" . date('d/m/Y') . ")";
$kemarin_label = "Kemarin (" . date('d/m/Y', strtotime('-1 day')) . ")";
$sebelumnya_label = "Sebelumnya (" . date('d/m/Y', strtotime('-2 day')) . ")";

$conn->close();
?>

<div class="visitor-stats">
    <h4 style="margin-bottom: 15px; color: #27ae60;">Kunjungan Website</h4>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 150px; padding: 10px; background-color: #f0f8f5; border-left: 4px solid #27ae60; border-radius: 4px;">
            <div style="font-size: 12px; color: #666; margin-bottom: 5px;"><?php echo $hari_ini_label; ?></div>
            <div style="font-size: 24px; font-weight: bold; color: #27ae60;"><?php echo $count_today; ?></div>
            <div style="font-size: 11px; color: #999;">pengunjung</div>
        </div>
        
        <div style="flex: 1; min-width: 150px; padding: 10px; background-color: #f0f8f5; border-left: 4px solid #27ae60; border-radius: 4px;">
            <div style="font-size: 12px; color: #666; margin-bottom: 5px;"><?php echo $kemarin_label; ?></div>
            <div style="font-size: 24px; font-weight: bold; color: #27ae60;"><?php echo $count_yesterday; ?></div>
            <div style="font-size: 11px; color: #999;">pengunjung</div>
        </div>
        
        <div style="flex: 1; min-width: 150px; padding: 10px; background-color: #f0f8f5; border-left: 4px solid #27ae60; border-radius: 4px;">
            <div style="font-size: 12px; color: #666; margin-bottom: 5px;"><?php echo $sebelumnya_label; ?></div>
            <div style="font-size: 24px; font-weight: bold; color: #27ae60;"><?php echo $count_before; ?></div>
            <div style="font-size: 11px; color: #999;">pengunjung</div>
        </div>
    </div>
</div>
