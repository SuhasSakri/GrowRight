<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
require_once "config.php";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $_SESSION['register_error'] = "Email is already registered!";
        $_SESSION['active_form'] = 'register';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO register (name, email, password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $email, $hashed);

        if($stmt->execute()){
            $_SESSION['register_success'] = "Registration successful. Please login.";
            $_SESSION['active_form'] = 'login';
        } else {
            $_SESSION['register_error'] = "Something went wrong. Try again.";
            $_SESSION['active_form'] = 'register';
        }
    }
    header("Location: login.php");
    exit();
}

// ---------------- LOGIN ----------------
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM register WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if($user['email'] === "admin@gmail.com"){
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid password!";
            $_SESSION['active_form'] = 'login';
        }
    } else {
        $_SESSION['login_error'] = "Email not found!";
        $_SESSION['active_form'] = 'login';
    }
    header("Location: login.php");
    exit();
}
?>
