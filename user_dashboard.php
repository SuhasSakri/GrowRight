<?php include("user_dashboard_php.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GrowRight | Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background-color: #f7fafc; }
    .navbar-brand { font-weight: bold; font-size: 1.5rem; }
    .section { display: none; padding: 40px; }
    .section.active { display: block; }
    .block {
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      cursor: pointer;
      text-align: center;
      transition: all 0.3s ease;
    }
    .block:hover { background-color: #e3f2fd; }

    .water-reminder {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      display: none;
      animation: fadeIn 1s ease-in-out;
    }
    .reminder-card {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: #fff;
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      width: 250px;
      text-align: center;
      position: relative;
      animation: bounce 1s infinite alternate;
    }
    .reminder-card button {
      margin-top: 15px;
      padding: 8px 15px;
      border: none;
      border-radius: 50px;
      background-color: #00ffdd;
      color: #0072ff;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .reminder-card button:hover {
      background-color: #0072ff;
      color: #00ffdd;
      transform: scale(1.1);
    }
    .water-icon { width: 50px; animation: float 2s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
    @keyframes bounce { 0%{transform:translateY(0);}100%{transform:translateY(-5px);} }
    @keyframes fadeIn { from{opacity:0;} to{opacity:1;} }
  </style>
</head>

<body>
 
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand ms-3" href="#">GrowRight</a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav me-3">
          <li class="nav-item"><a class="nav-link active tab-link" data-tab="dashboard" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="routines" href="#">Routines</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="nutrition" href="#">Nutrition</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="profile" href="#">Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <main class="container mt-4">


    <section id="dashboard" class="section active text-center">
      <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
      <p>Select a section from the navbar to continue.</p>

  
      <?php if ($profile): ?>
        <div class="card mx-auto mt-4 p-3 shadow" style="max-width:500px;">
          <h4 class="mb-3 text-primary">Your Profile Summary</h4>
          <table class="table table-borderless text-start">
            <tr><th>Name:</th><td><?= htmlspecialchars($profile['name']); ?></td></tr>
            <tr><th>Date of Birth:</th><td><?= htmlspecialchars($profile['dob']); ?></td></tr>
            <tr><th>Height:</th><td><?= htmlspecialchars($profile['height']); ?> cm</td></tr>
            <tr><th>Weight:</th><td><?= htmlspecialchars($profile['weight']); ?> kg</td></tr>
            <tr><th>Region:</th><td><?= htmlspecialchars($profile['region']); ?></td></tr>
          </table>
        </div>
      <?php else: ?>
        <p class="mt-3 text-muted">No profile found. Please create your profile in the <b>Profile</b> tab.</p>
      <?php endif; ?>
    </section>

   
    <section id="routines" class="section text-center">
      <h2>Choose Your Activity Type</h2>
      <div class="row justify-content-center mt-4">
        <div class="col-md-4"><div class="block" id="physical">🏃‍♂️ Physical Activity</div></div>
        <div class="col-md-4"><div class="block" id="mental">🧠 Mental Activity</div></div>
      </div>
    </section>

    
    <section id="nutrition" class="section text-center">
      <h2>Nutrition</h2>
      <p>Track your meals, hydration, and nutrition plans.</p>
    </section>

  
    <section id="profile" class="section">
      <div class="card mx-auto shadow p-4" style="max-width:500px;">
        <h3 class="text-center mb-3">Your Profile</h3>
        <form action="save_profile.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Height (cm)</label>
            <input type="number" name="height" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Weight (kg)</label>
            <input type="number" name="weight" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Region</label>
            <select name="region" class="form-select" required>
              <option value="">--Select Your State--</option>
              <option value="North-karnataka">North Karnataka</option>
              <option value="South-karnataka">South Karnataka</option>
              <option value="East-karnataka">East Karnataka</option>
              <option value="West-karnataka">West Karnataka</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Save Profile</button>
        </form>
      </div>
    </section>

  </main>

  
  <div class="water-reminder">
    <div class="reminder-card">
      <img src="images/water.png" alt="Water Glass" class="water-icon" />
      <h2>Time to Drink Water! 💧</h2>
      <p>Keep yourself hydrated for a healthy body.</p>
      <button onclick="dismissReminder()">Got it!</button>
    </div>
  </div>


  <script src="user_script.js"></script>
</body>
</html>
