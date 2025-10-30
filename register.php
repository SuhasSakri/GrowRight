<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | GrowRight</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 
  <script src="https://kit.fontawesome.com/a2e0f1f6b8.js" crossorigin="anonymous"></script>

  <style>
    body {
      background: #f0f4f8;
    }
    .form-box {
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 450px;
      margin: 80px auto;
      position: relative;
    }
    .form_close {
      position: absolute;
      right: 15px;
      top: 15px;
      color: #999;
      font-size: 1.2rem;
      cursor: pointer;
    }
    .form-box {
  transition: all 0.3s ease;
}
.form-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.form_close:hover {
  color: #28a745;
  transform: scale(1.1);
  transition: all 0.3s ease;
}

input.form-control {
  transition: all 0.3s ease;
}
input.form-control:focus {
  box-shadow: 0 0 8px rgba(40,167,69,0.5);
  border-color: #28a745;
}

.btn-success {
  transition: all 0.3s ease;
}
.btn-success:hover {
  background-color: #28a745cc;
  transform: scale(1.05);
}

a {
  transition: color 0.3s ease;
  text-decoration:none;
}

  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand ms-3" href="index.php">GrowRight</a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav me-3">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="form-box">
      <a href="index.php"><i class="fa-regular fa-circle-xmark form_close"></i></a>
      <h2 class="text-center mb-4">REGISTER</h2>

      <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
      <?php endif; ?>

      <form action="register_backend.php" method="post">
        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name" required />
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required />
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required />
        </div>
        <button type="submit" name="register" class="btn btn-success w-100">Register</button>
      </form>

      <p class="text-center mt-3">
        Already have an account?
        <a href="login.php">Login</a>
      </p>
    </div>
  </div>
</body>
</html>
