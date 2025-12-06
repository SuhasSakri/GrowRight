<?php
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$today = date("Y-m-d");
$user_id = $_SESSION['user_id'];

// Get water data from database
$sql = "SELECT water_intake, water_intake_date, last_water_reminder FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$water_intake = $data['water_intake'] ?? 0;
$water_intake_date = $data['water_intake_date'] ?? null;
$last_water_reminder = $data['last_water_reminder'] ?? null;

// Reset water intake if new day
if ($water_intake_date !== $today) {
    $water_intake = 0;
    $water_intake_date = $today;
}

// Update session
$_SESSION['water_intake'] = $water_intake;
$_SESSION['water_intake_date'] = $water_intake_date;
$_SESSION['last_water_reminder'] = $last_water_reminder;

// Handle water button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drink_water'])) {
    $water_intake++;
    $last_water_reminder = time();
    
    $updateSql = "UPDATE profiles SET water_intake = ?, water_intake_date = ?, last_water_reminder = ? WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("isii", $water_intake, $water_intake_date, $last_water_reminder, $user_id);
    $updateStmt->execute();
    
    $_SESSION['water_intake'] = $water_intake;
    $_SESSION['last_water_reminder'] = $last_water_reminder;
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
