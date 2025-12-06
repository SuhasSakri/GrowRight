<?php
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $con = new mysqli("localhost", "root", "", "growright_db");
    if ($con->connect_error) {
        $_SESSION['message'] = "DB connection failed!";
        header("Location: login.php");
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: user_dashboard.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password!";
        }
    } else {
        $_SESSION['message'] = "User not found!";
    }

    header("Location: login.php");
    exit();
}
?>