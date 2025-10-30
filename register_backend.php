<?php
session_start();

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $con = mysqli_connect("localhost", "root", "", "growright_db");

    if (mysqli_connect_errno()) {
        $_SESSION['message'] = "Database connection failed!";
        header("Location: register.php");
        exit();
    }

    
    $check = $con->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Email already registered!";
        header("Location: register.php");
    } else {
        $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();

        $_SESSION['message'] = "Registration successful! You can now login.";
        header("Location: login.php");
    }

    $stmt->close();
    $check->close();
    mysqli_close($con);
}
?>
