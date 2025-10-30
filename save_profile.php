<?php
session_start();

$host = "localhost";
$user = "root";  
$pass = "";     
$db   = "growright_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Database Connection Failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $name = $_POST['name'];
  $dob = $_POST['dob'];
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $region = $_POST['region'];

  // Check if profile exists
  $check = $conn->prepare("SELECT * FROM profiles WHERE user_id=?");
  $check->bind_param("i", $user_id);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    // Update profile
    $stmt = $conn->prepare("UPDATE profiles SET name=?, dob=?, height=?, weight=?, region=? WHERE user_id=?");
    $stmt->bind_param("ssddsi", $name, $dob, $height, $weight, $region, $user_id);
  } else {
    // Insert new profile
    $stmt = $conn->prepare("INSERT INTO profiles (user_id, name, dob, height, weight, region) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdds", $user_id, $name, $dob, $height, $weight, $region);
  }

  if ($stmt->execute()) {
    echo "<script>alert('Profile saved successfully!'); window.location.href='user_dashboard.php';</script>";
  } else {
    echo "<script>alert('Error saving profile.'); window.location.href='user_dashboard.php';</script>";
  }
}
?>
