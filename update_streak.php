<?php
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$today = date("Y-m-d");
$user_id = $_SESSION['user_id'];

$sql = "SELECT streak, last_login FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$streak = $data['streak'] ?? 1;
$last_login = $data['last_login'] ?? null;

if ($last_login !== $today) {
    if ($last_login) {
        $lastDate = new DateTime($last_login);
        $todayDate = new DateTime($today);
        $dayDiff = $lastDate->diff($todayDate)->days;
        
        $streak = ($dayDiff === 1) ? $streak + 1 : 1;
    }
    
    $updateSql = "UPDATE profiles SET streak = ?, last_login = ? WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("isi", $streak, $today, $user_id);
    $updateStmt->execute();
}

$_SESSION['streak'] = $streak;
$_SESSION['last_login'] = $today;
?>
