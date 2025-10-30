<?php
session_start();

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match!";
        header("Location: admin_reset_password.php");
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $con = new mysqli("localhost", "root", "", "growright_db");
    if ($con->connect_error) {
        $_SESSION['message'] = "DB connection failed!";
        header("Location: admin_reset_password.php");
        exit();
    }

    $stmt = $con->prepare("UPDATE admins SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Password reset successful!";
    } else {
        $_SESSION['message'] = "Admin email not found!";
    }

    $stmt->close();
    $con->close();

    header("Location: admin_reset_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Password Reset | GrowRight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto p-4 shadow" style="max-width: 450px;">
        <h3 class="text-center mb-3">Admin Password Reset</h3>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Admin Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
            </div>
            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <button type="submit" name="reset" class="btn btn-warning w-100">Reset Password</button>
        </form>
    </div>
</div>
</body>
</html>
