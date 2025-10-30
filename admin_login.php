<?php
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con = new mysqli("localhost", "root", "", "growright_db");
    if ($con->connect_error) {
        $_SESSION['message'] = "DB connection failed!";
        header("Location: admin_login.php");
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password!";
        }
    } else {
        $_SESSION['message'] = "Admin not found!";
    }

    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | GrowRight</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card mx-auto p-4 shadow" style="max-width: 400px;">
    <h3 class="text-center mb-3">Admin Login</h3>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-warning text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Admin Email" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3">
        <a href="admin_reset_password.php">Forgot Password? Reset Here</a>
    </p>
  </div>
</div>
</body>
</html>
