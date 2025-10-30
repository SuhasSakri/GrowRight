<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$con = new mysqli("localhost", "root", "", "growright_db");
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Fetch users
$user_result = $con->query("SELECT * FROM users ORDER BY id DESC");
$user_count = $user_result->num_rows;

// Optional: handle deletion
if (isset($_GET['delete_user'])) {
    $delete_id = intval($_GET['delete_user']);
    $con->query("DELETE FROM users WHERE id = $delete_id");
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | GrowRight</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a2e0f1f6b8.js" crossorigin="anonymous"></script>
<style>
.navbar-nav .nav-link.btn {
    transition: all 0.3s ease;
}
.navbar-nav .nav-link.btn:hover {
    background-color: #ffc107;
    color: #000 !important;
    transform: scale(1.05);
}
</style>

</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="#">GrowRight Admin</a>
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
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Total Users</h5>
          <p class="card-text display-6"><?= $user_count ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <a href="admin_add_user.php" class="text-decoration-none">
        <div class="card text-center shadow-sm bg-success text-white">
          <div class="card-body">
            <h5 class="card-title">Add New User</h5>
            <p class="card-text"><i class="fa fa-plus fa-2x"></i></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <div class="card text-center shadow-sm bg-info text-white">
        <div class="card-body">
          <h5 class="card-title">Admin Options</h5>
          <p class="card-text">View user profiles and delete users</p>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">User List</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Registered At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($user = $user_result->fetch_assoc()): ?>
          <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['created_at'] ?></td>
            <td>
              <a href="admin_view_user.php?user_id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">View</a>
              <a href="?delete_user=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
