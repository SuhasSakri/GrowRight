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

$message = "";

if (isset($_POST['add_user'])) {
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $con->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $con->query("INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')");
        $message = "User added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New User | GrowRight Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="admin_dashboard.php">GrowRight Admin</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><span class="nav-link text-white">Welcome, <?= htmlspecialchars($_SESSION['admin_name']); ?></span></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="admin_logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card mx-auto shadow-sm p-4" style="max-width:500px;">
    <h3 class="text-center mb-4 text-primary">Add New User</h3>

    <?php if($message): ?>
      <div class="alert alert-info text-center"><?= $message; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" name="add_user" class="btn btn-success w-100">Add User</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
