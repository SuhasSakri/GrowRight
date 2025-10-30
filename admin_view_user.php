<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['user_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$user_id = intval($_GET['user_id']);
$con = new mysqli("localhost", "root", "", "growright_db");
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Fetch user info
$user_result = $con->query("SELECT * FROM users WHERE id = $user_id");
if ($user_result->num_rows !== 1) {
    $_SESSION['message'] = "User not found!";
    header("Location: admin_dashboard.php");
    exit();
}
$user = $user_result->fetch_assoc();

// Fetch profile info
$profile_result = $con->query("SELECT * FROM profiles WHERE user_id = $user_id");
$profile = $profile_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View User Profile | GrowRight Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f7fafc; }
    .profile-card { border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    th { width: 35%; }
    td { width: 65%; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="admin_dashboard.php">GrowRight Admin</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav me-3">
        <li class="nav-item">
          <span class="nav-link text-white">Welcome, <?= htmlspecialchars($_SESSION['admin_name']); ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light ms-2" href="admin_logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card profile-card mx-auto" style="max-width:650px;">
    <h3 class="text-center mb-4 text-primary">User Profile</h3>

    <table class="table table-borderless">
      <tr><th>Name:</th><td><?= htmlspecialchars($user['name']); ?></td></tr>
      <tr><th>Email:</th><td><?= htmlspecialchars($user['email']); ?></td></tr>
      <tr><th>Registered At:</th><td><?= $user['created_at']; ?></td></tr>

      <?php if ($profile): ?>
        <tr><th>Date of Birth:</th><td><?= htmlspecialchars($profile['dob']); ?></td></tr>
        <tr><th>Height:</th><td><?= htmlspecialchars($profile['height']); ?> cm</td></tr>
        <tr><th>Weight:</th><td><?= htmlspecialchars($profile['weight']); ?> kg</td></tr>
        <tr><th>Region:</th><td><?= htmlspecialchars($profile['region']); ?></td></tr>
      <?php else: ?>
        <tr><td colspan="2" class="text-muted text-center">Profile not created yet.</td></tr>
      <?php endif; ?>
    </table>

    <div class="text-center mt-4">
      <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
