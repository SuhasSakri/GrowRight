<?php
include("user_dashboard_php.php");

// Calculate age from profile
$userAge = null;
if (!empty($profile['dob'])) {
    $dob = new DateTime($profile['dob']);
    $today = new DateTime();
    $userAge = $dob->diff($today)->y;
}

// Structured nutrition recommendations for ages 3-5, 6-9, 10-13
$nutritionTips = [];
if ($profile && $userAge !== null) {
    $region = $profile['region'] ?? '';

    if ($userAge >= 3 && $userAge <= 5) $ageCategory = '3-5';
    elseif ($userAge >= 6 && $userAge <= 9) $ageCategory = '6-9';
    elseif ($userAge >= 10 && $userAge <= 13) $ageCategory = '10-13';
    else $ageCategory = null;

    $regionTips = [
        'North-karnataka' => [
            '3-5' => [
                'Breakfast' => 'Ragi porridge with milk and fruits',
                'Lunch' => 'Boiled vegetables with soft chapati',
                'Snack' => 'Seasonal soft fruits or milk',
                'Dinner' => 'Light vegetable soup or porridge'
            ],
            '6-9' => [
                'Breakfast' => 'Ragi roti with milk',
                'Lunch' => 'Lentils, rice, seasonal vegetables',
                'Snack' => 'Fruits or nuts',
                'Dinner' => 'Vegetable curry with roti or rice'
            ],
            '10-13' => [
                'Breakfast' => 'Ragi roti or porridge with milk',
                'Lunch' => 'Vegetables, legumes, moderate protein like eggs or chicken',
                'Snack' => 'Fruits, sprouts, or nuts',
                'Dinner' => 'Balanced rice/roti meal with vegetables and protein'
            ]
        ],
        'South-karnataka' => [
            '3-5' => [
                'Breakfast' => 'Rice porridge with curd and fruits',
                'Lunch' => 'Soft rice with vegetables and lentils',
                'Snack' => 'Seasonal fruits',
                'Dinner' => 'Light rice or porridge'
            ],
            '6-9' => [
                'Breakfast' => 'Rice with curd or coconut-based dishes',
                'Lunch' => 'Rice, lentils, vegetables',
                'Snack' => 'Fruits or sprouts',
                'Dinner' => 'Balanced rice meal with vegetables and protein'
            ],
            '10-13' => [
                'Breakfast' => 'Rice or ragi porridge with milk',
                'Lunch' => 'Rice with vegetables, legumes, moderate protein',
                'Snack' => 'Fruits, nuts, or sprouts',
                'Dinner' => 'Vegetable curry with rice or chapati'
            ]
        ],
        'East-karnataka' => [
            '3-5' => [
                'Breakfast' => 'Jowar porridge with milk and fruits',
                'Lunch' => 'Soft jowar roti with vegetables',
                'Snack' => 'Seasonal fruits',
                'Dinner' => 'Light vegetable soup or porridge'
            ],
            '6-9' => [
                'Breakfast' => 'Jowar roti with milk',
                'Lunch' => 'Lentils, vegetables, rice or roti',
                'Snack' => 'Sprouts or fruits',
                'Dinner' => 'Vegetable curry with jowar roti'
            ],
            '10-13' => [
                'Breakfast' => 'Jowar roti or porridge with milk',
                'Lunch' => 'Jowar, vegetables, legumes, moderate protein',
                'Snack' => 'Fruits or nuts',
                'Dinner' => 'Balanced meal with vegetables and protein'
            ]
        ],
        'West-karnataka' => [
            '3-5' => [
                'Breakfast' => 'Ragi porridge with milk and fruits',
                'Lunch' => 'Soft vegetables with ragi roti',
                'Snack' => 'Seasonal fruits or milk',
                'Dinner' => 'Light vegetable soup or porridge'
            ],
            '6-9' => [
                'Breakfast' => 'Ragi roti with milk',
                'Lunch' => 'Legumes, vegetables, rice or roti',
                'Snack' => 'Fruits or nuts',
                'Dinner' => 'Vegetable curry with roti or rice'
            ],
            '10-13' => [
                'Breakfast' => 'Ragi porridge or roti with milk',
                'Lunch' => 'Vegetables, legumes, protein-rich foods like eggs or lentils',
                'Snack' => 'Fruits, sprouts, or nuts',
                'Dinner' => 'Balanced meal with vegetables and protein'
            ]
        ]
    ];

    if ($ageCategory && isset($regionTips[$region][$ageCategory])) {
        $nutritionTips = $regionTips[$region][$ageCategory];
    } else {
        $nutritionTips = [
            'Breakfast' => 'Milk and fruits',
            'Lunch' => 'Vegetables and rice/roti',
            'Snack' => 'Fruits or nuts',
            'Dinner' => 'Light meal with vegetables and protein'
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GrowRight | Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .navbar-brand { font-size: 1.5rem; }
    .section { display: none; }
    .section.active { display: block; }
    .card { border-radius: 12px; }
    .table th { width: 40%; }
    .btn-primary, .btn-success { font-weight: 600; }
    .tab-link.active { font-weight: bold; border-bottom: 2px solid #0d6efd; }
    #activityList button { border-radius: 10px; margin-bottom: 8px; }
    #nutrition ul { max-width: 600px; margin: 0 auto; text-align: left; padding-left: 20px; }
    .water-reminder { position: fixed; bottom: 20px; right: 20px; z-index: 1000; animation: fadeIn 1s ease-in-out; }
    .reminder-card { background: linear-gradient(135deg, #00c6ff, #0072ff); color: #fff; padding: 25px 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); width: 250px; text-align: center; position: relative; animation: bounce 1s infinite alternate; }
    .reminder-card h2 { margin: 10px 0; font-size: 18px; }
    .reminder-card p { font-size: 14px; }
    .reminder-card button { margin-top: 15px; padding: 8px 15px; border: none; border-radius: 50px; background-color: #00ffdd; color: #0072ff; font-weight: bold; cursor: pointer; transition: all 0.3s ease; }
    .reminder-card button:hover { background-color: #0072ff; color: #00ffdd; transform: scale(1.1); }
    .water-icon { width: 50px; animation: float 2s ease-in-out infinite; }
    @keyframes float { 0% { transform: translateY(0); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0); } }
    @keyframes bounce { 0% { transform: translateY(0); } 100% { transform: translateY(-5px); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .bmi-underweight { background-color: #cce5ff; }
    .bmi-normal { background-color: #d4edda; }
    .bmi-overweight { background-color: #fff3cd; }
    .bmi-obese { background-color: #f8d7da; }
    .bmi-info { font-size: 0.9rem; color: #333; margin-top: 5px; }
    .bg-breakfast { background-color: #fff3cd; color:#333; }
.bg-lunch { background-color: #d4edda; color:#155724; }
.bg-snack { background-color: #cce5ff; color:#004085; }
.bg-dinner { background-color: #d6d8d9; color:#383d41; }
/* Hover effect for premium feel */
  .meal-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 12px 25px rgba(0,0,0,0.3);
  }

  /* Smooth transition for cards */
  .meal-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  /* Badge styling */
  .badge {
      font-size: 0.8rem;
      font-weight: 500;
  }

  .meal-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .meal-card:hover { transform: translateY(-5px) scale(1.02); box-shadow:0 12px 25px rgba(0,0,0,0.3); }

  .badge { font-size: 0.8rem; font-weight: 500; }
  .progress { background-color: rgba(0,0,0,0.05); }
  .progress-bar { border-radius: 10px; }

  .floating-icon {
      position: absolute; top: -12px; right: -12px; font-size:1.6rem; animation: float 2s ease-in-out infinite;
  }
  @keyframes float { 0%{transform:translateY(0);}50%{transform:translateY(-8px);}100%{transform:translateY(0);} }

  /* Scroll animation for meal emoji */
  .meal-emoji { display:inline-block; transition: transform 0.6s ease, opacity 0.6s ease; opacity:0; }
  .meal-emoji.visible { transform: translateY(-10px) rotate(-10deg); opacity:1; }

  /* Vertical gradient line connecting meals */
  .nutrition-line {
      width: 4px;
      height: calc(100% - 40px);
      background: linear-gradient(to bottom, rgba(0,123,255,0.4), rgba(0,123,255,0.1));
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
      z-index:0;
  }

  .streak-card {
  border-radius: 20px;
  animation: floatStreak 2s ease-in-out infinite alternate;
}
@keyframes floatStreak {
  0% { transform: translateY(0px); }
  100% { transform: translateY(-5px); }
}
.streak-fire {
  font-size: 1.5rem;
  animation: flicker 1.5s infinite alternate;
}
.streak-empty {
  font-size: 1.5rem;
  opacity: 0.3;
}
@keyframes flicker {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.2); }
}

.btn-gradient-physical {
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  color: white;
  font-weight: 600;
  font-size: 1.1rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-gradient-physical:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.btn-gradient-mental {
  background: linear-gradient(135deg, #43e97b, #38f9d7);
  color: white;
  font-weight: 600;
  font-size: 1.1rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-gradient-mental:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

/* Activity Buttons Hover Glow */
.activity-btn {
  border-radius: 15px;
}

/* Modal Customizations */
.modal-content {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px);}
  100% { opacity: 1; transform: translateY(0);}
}

/* Optional: Animate button text */
.btn-text {
  display: inline-block;
  transition: transform 0.3s;
}
.activity-btn:hover .btn-text {
  transform: scale(1.05);
}
</style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">GrowRight</a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active tab-link" data-tab="dashboard" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="routines" href="#">Routines</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="nutrition" href="#">Nutrition</a></li>
          <li class="nav-item"><a class="nav-link tab-link" data-tab="profile" href="#">Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    
    <!-- 🏠 Dashboard Section -->
<section id="dashboard" class="section active text-center">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
  <p class="text-muted">Select a section from the navigation bar to continue.</p>

  <?php if ($profile): ?>

    <!-- 🔥 STREAK CARD -->
    <?php
      $age = $userAge;
      $region = $profile['region'];

      if ($age >= 3 && $age <= 13) {
        $streak = $_SESSION['streak'] ?? 0; // Replace with actual streak logic
        echo '<div class="card mx-auto mt-3 shadow-lg border-0 streak-card" style="max-width:500px; background: linear-gradient(135deg,#ffcc80,#ffb74d); border-radius:20px;">';
        echo '<div class="card-body text-center">';
        echo '<h4 class="mb-2">🔥 Daily Login Streak</h4>';
        echo '<p class="fs-4 mb-1"><strong>'.$streak.'</strong> day'.($streak==1?'':'s').' in a row!</p>';
        echo '<div class="d-flex justify-content-center gap-1 mb-2">';
        for ($i = 1; $i <= 7; $i++) {
          echo $i <= $streak ? '<span class="streak-fire">🔥</span>' : '<span class="streak-empty">⚪</span>';
        }
        echo '</div>';
        echo '<p class="text-muted small">Keep your streak going to stay motivated and healthy!</p>';
        echo '</div></div>';
      }
    ?>

    <!-- PROFILE SUMMARY -->
    <div class="card mx-auto mt-4 shadow-lg border-0" style="max-width:700px; background: linear-gradient(135deg, #e3f2fd, #fff);">
      <div class="card-body text-start">
        <h4 class="text-primary mb-3 text-center">👤 Your Profile Summary</h4>
        <table class="table table-borderless mb-0">
          <tr><th>Name:</th><td><?= htmlspecialchars($profile['name']); ?></td></tr>
          <tr><th>Date of Birth:</th><td><?= htmlspecialchars($profile['dob']); ?></td></tr>
          <tr><th>Height:</th><td><?= htmlspecialchars($profile['height']); ?> cm</td></tr>
          <tr><th>Weight:</th><td><?= htmlspecialchars($profile['weight']); ?> kg</td></tr>
          <tr><th>Region:</th><td><?= htmlspecialchars($profile['region']); ?></td></tr>
          <?php if ($userAge): ?>
            <tr><th>Age:</th><td><?= $userAge; ?> years</td></tr>
          <?php endif; ?>
        </table>
      </div>
    </div>

    <!-- BMI CARD -->
    <?php if (!empty($profile['height']) && !empty($profile['weight'])): 
      $height_m = $profile['height'] / 100;
      $weight_kg = $profile['weight'];
      $bmi = round($weight_kg / ($height_m * $height_m), 1);
      if ($bmi < 18.5) { $bmi_category = "Underweight"; $bmi_color="#ffcc80"; $bmi_info="You are underweight. Consider a nutritious diet to gain weight healthily."; }
      elseif ($bmi < 25) { $bmi_category = "Normal"; $bmi_color="#a5d6a7"; $bmi_info="Your BMI is normal. Maintain a balanced diet and regular activity."; }
      elseif ($bmi < 30) { $bmi_category = "Overweight"; $bmi_color="#fff59d"; $bmi_info="You are overweight. Focus on exercise and balanced nutrition."; }
      else { $bmi_category = "Obese"; $bmi_color="#ef9a9a"; $bmi_info="You are obese. Consult a health professional for proper guidance."; }
    ?>
      <div class="card mx-auto mt-4 shadow-lg border-0" style="max-width:400px; background: <?= $bmi_color; ?>;">
        <div class="card-body">
          <h4 class="mb-2">Your BMI</h4>
          <p class="mb-0 fs-5"><strong><?= $bmi; ?></strong> - <?= $bmi_category; ?></p>
          <p class="text-muted"><?= $bmi_info; ?></p>
        </div>
      </div>

      <!-- DAILY NUTRITION TARGETS FOR AGE 3-13 -->
      <?php
        if ($age >= 3 && $age <= 13) {
          if ($age >= 3 && $age <= 5) {
            $dailyGoals = ['calories'=>1400, 'protein'=>35, 'fiber'=>15, 'vitamins'=>'A, C, D, Calcium'];
          } elseif ($age >= 6 && $age <= 9) {
            $dailyGoals = ['calories'=>1600, 'protein'=>45, 'fiber'=>20, 'vitamins'=>'A, B, C, D'];
          } else { // 10-13
            $dailyGoals = ['calories'=>1800, 'protein'=>55, 'fiber'=>25, 'vitamins'=>'A, B, C, D, Iron'];
          }

          // Adjust based on Karnataka zone
          switch ($region) {
            case 'North Karnataka': $dailyGoals['fiber'] += 2; break;
            case 'South Karnataka': $dailyGoals['protein'] += 2; break;
            case 'East Karnataka': $dailyGoals['calories'] -= 50; break;
            case 'West Karnataka': $dailyGoals['vitamins'] .= ', K'; break;
          }

          echo '<div class="card mx-auto mt-4 shadow-lg border-0" style="max-width:700px; background: linear-gradient(135deg, #e8f5e9, #fff); border-radius:15px;">';
          echo '<div class="card-body">';
          echo '<h4 class="text-success text-center mb-3">Daily Nutrition Targets</h4>';
          echo '<div class="row justify-content-center">';
          echo '<div class="col-md-6">';
          echo '<ul class="list-unstyled fs-5 text-start">';
          foreach ($dailyGoals as $key => $value) {
            echo '<li><strong>'.ucfirst($key).':</strong> '.$value.($key==='calories'?' kcal':($key==='protein'||$key==='fiber'?' g':'' )).'</li>';
          }
          echo '</ul>';
          echo '</div></div>';
          echo '<p class="text-muted small text-center mt-2">Aim to meet these targets today for optimal health based on your age and region.</p>';
          echo '</div></div>';
        }
      ?>
    <?php endif; ?>
  <?php else: ?>
    <p class="mt-3 text-muted">No profile found. Please create your profile in the <b>Profile</b> tab.</p>
  <?php endif; ?>
</section>


<!-- 🏃‍♂️ Routines Section -->
    <section id="routines" class="section text-center">
  <h2 class="mb-4">Choose Your Activity Type</h2>

  <div class="row justify-content-center mb-4">
    <div class="col-md-4 mb-3">
      <button class="btn btn-gradient-physical w-100 py-4 shadow-lg activity-btn" id="physical">
        🏃‍♂️ <span class="btn-text">Physical Activities</span>
      </button>
    </div>
    <div class="col-md-4 mb-3">
      <button class="btn btn-gradient-mental w-100 py-4 shadow-lg activity-btn" id="mental">
        🧠 <span class="btn-text">Mental Activities</span>
      </button>
    </div>
  </div>

  <div id="activityPage" class="d-none">
    <button class="btn btn-outline-secondary mb-3" onclick="goBack()">← Back</button>
    <h4 id="activityTitle" class="mb-3"></h4>
    <div id="activityList" class="list-group"></div>
  </div>

  <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg border-0 rounded-4">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title" id="infoTitle"></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="infoDescription"></div>
      </div>
    </div>
  </div>
</section>

<!-- 🥗 Nutrition Section -->
<section id="nutrition" class="section text-center py-5" style="background: linear-gradient(135deg, #fdfbfb, #ebedee);">
  <h2 class="mb-5">Nutrition</h2>

  <?php
  $mealIcons = ['Breakfast'=>'🍳','Lunch'=>'🍛','Snack'=>'🥪','Dinner'=>'🍲'];
  $floatingIcons = ['Breakfast'=>'🥚','Lunch'=>'🥗','Snack'=>'🍎','Dinner'=>'🍲'];
  $mealGradients = [
      'Breakfast'=>'linear-gradient(135deg, #FFFAE3, #FFF2AA)',
      'Lunch'=>'linear-gradient(135deg, #E2F9E1, #B9F0B3)',
      'Snack'=>'linear-gradient(135deg, #E1F0FA, #A6D8FF)',
      'Dinner'=>'linear-gradient(135deg, #F9E1FF, #E6B3FF)'
  ];

  $meals = $nutritionTips ?: [
      'Breakfast'=>'Milk and fruits',
      'Lunch'=>'Vegetables and rice/roti',
      'Snack'=>'Fruits or nuts',
      'Dinner'=>'Light meal with vegetables and protein'
  ];

  function estimateNutrients($mealText) {
      $calories = 300; $protein = 8; $fiber = 3;
      $lower = strtolower($mealText);
      if (str_contains($lower, 'ragi')) { $calories = 350; $protein = 10; $fiber = 4; }
      if (str_contains($lower, 'rice')) { $calories = 400; $protein = 12; $fiber = 5; }
      if (str_contains($lower, 'porridge')) { $calories = 250; $protein = 7; $fiber = 3; }
      if (str_contains($lower, 'milk')) { $calories = 180; $protein = 6; $fiber = 1; }
      if (str_contains($lower, 'vegetable')) { $calories = 320; $protein = 9; $fiber = 6; }
      if (str_contains($lower, 'chicken') || str_contains($lower, 'egg')) { $calories = 500; $protein = 25; $fiber = 2; }
      if (str_contains($lower, 'fruits')) { $calories = 150; $protein = 3; $fiber = 4; }
      if (str_contains($lower, 'nuts') || str_contains($lower, 'sprouts')) { $calories = 200; $protein = 8; $fiber = 5; }
      if (str_contains($lower, 'lentil') || str_contains($lower, 'dal')) { $calories = 380; $protein = 18; $fiber = 7; }
      if (str_contains($lower, 'soup')) { $calories = 220; $protein = 6; $fiber = 4; }
      return ['calories'=>$calories,'protein'=>$protein,'fiber'=>$fiber];
  }

  $mealData = [];
  $totalCalories = 0;
  $totalProtein = 0;
  $totalFiber = 0;
  foreach ($meals as $meal => $tip) {
      $info = estimateNutrients($tip);
      $mealData[$meal] = $info;
      $totalCalories += $info['calories'];
      $totalProtein += $info['protein'];
      $totalFiber += $info['fiber'];
  }

  $dailyGoals = [
      '3-5' => ['calories'=>1200, 'protein'=>25, 'fiber'=>15],
      '6-9' => ['calories'=>1600, 'protein'=>35, 'fiber'=>20],
      '10-13' => ['calories'=>2000, 'protein'=>45, 'fiber'=>25],
  ];

  $currentAgeGroup = null;
  if ($userAge >= 3 && $userAge <= 5) $currentAgeGroup = '3-5';
  elseif ($userAge >= 6 && $userAge <= 9) $currentAgeGroup = '6-9';
  elseif ($userAge >= 10 && $userAge <= 13) $currentAgeGroup = '10-13';

  $goals = $dailyGoals[$currentAgeGroup] ?? ['calories'=>1500, 'protein'=>30, 'fiber'=>18];

  function getProgressColor($percent) {
      if ($percent >= 90) return '#4CAF50'; 
      if ($percent >= 60) return '#FFC107'; 
      return '#F44336'; 
  }

  $calPercent = min(100, round(($totalCalories/$goals['calories'])*100));
  $proteinPercent = min(100, round(($totalProtein/$goals['protein'])*100));
  $fiberPercent = min(100, round(($totalFiber/$goals['fiber'])*100));

  $calColor = getProgressColor($calPercent);
  $proteinColor = getProgressColor($proteinPercent);
  $fiberColor = getProgressColor($fiberPercent);

  // Daily tip
  $tips = [
      "💧 Stay hydrated — drink at least 8 glasses of water today!",
      "🍎 Eat a fruit between meals to boost your energy naturally!",
      "🥕 Include colorful veggies for a variety of vitamins!",
      "🍚 Don’t skip breakfast — it fuels your day!",
      "🍗 Add protein to every meal for strength and growth!",
      "🌽 Whole grains help your digestion — include them daily!",
      "🍌 A banana a day keeps fatigue away!"
  ];
  $todayIndex = date('z') % count($tips);
  $dailyTip = $tips[$todayIndex];
  ?>

  <div class="d-flex justify-content-center align-items-start flex-wrap gap-4">

    <!-- LEFT: Meal Recommendations -->
    <div class="d-flex flex-column align-items-start" style="flex:1; min-width:300px; max-width:500px;">
      <?php foreach ($meals as $meal => $tip):
          $icon = $mealIcons[$meal];
          $floatIcon = $floatingIcons[$meal];
          $gradient = $mealGradients[$meal];
          $info = $mealData[$meal];
      ?>
          <div class="card mb-5 shadow-sm meal-card position-relative p-3" style="width:100%; background:<?= $gradient ?>; border-radius:20px;">
            <div class="d-flex align-items-center">
              <div class="fs-2 position-relative meal-emoji"><?= $icon ?><span class="floating-icon"><?= $floatIcon ?></span></div>
              <div class="text-start ms-3 flex-grow-1">
                <h5 class="mb-2 fw-bold"><?= htmlspecialchars($meal) ?></h5>
                <p class="mb-2"><?= htmlspecialchars($tip) ?></p>
                <div class="d-flex flex-wrap gap-2">
                  <span class="badge bg-light text-dark">🔥 <?= $info['calories'] ?> kcal</span>
                  <span class="badge bg-light text-dark">💪 <?= $info['protein'] ?> g</span>
                  <span class="badge bg-light text-dark">🌾 <?= $info['fiber'] ?> g</span>
                </div>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
    </div>

    <!-- RIGHT: Daily Nutrition Goal + Progress + Tip -->
    <div class="d-flex flex-column align-items-end" style="flex:1; min-width:280px; max-width:400px;">

      <div class="card shadow-sm mb-4" style="width:100%; border-radius:15px; background:linear-gradient(135deg,#e8f5e9,#c8e6c9);">
        <div class="card-body">
          <h5 class="fw-bold mb-3 text-center">Daily Nutrition Goal (Age <?= $currentAgeGroup ?>)</h5>

          <div class="mb-2">Calories: <?= $totalCalories ?> / <?= $goals['calories'] ?> kcal</div>
          <div class="progress mb-3" style="height:10px; border-radius:5px;">
            <div class="progress-bar" style="width:<?= $calPercent ?>%; background-color:<?= $calColor ?>;"></div>
          </div>

          <div class="mb-2">Protein: <?= $totalProtein ?> / <?= $goals['protein'] ?> g</div>
          <div class="progress mb-3" style="height:10px; border-radius:5px;">
            <div class="progress-bar" style="width:<?= $proteinPercent ?>%; background-color:<?= $proteinColor ?>;"></div>
          </div>

          <div class="mb-2">Fiber: <?= $totalFiber ?> / <?= $goals['fiber'] ?> g</div>
          <div class="progress" style="height:10px; border-radius:5px;">
            <div class="progress-bar" style="width:<?= $fiberPercent ?>%; background-color:<?= $fiberColor ?>;"></div>
          </div>
        </div>
      </div>

      <div id="daily-tip" class="card shadow-sm fade-slide" style="width:100%; border-radius:15px; background:linear-gradient(135deg,#fff8e1,#ffe0b2); opacity:0; transform:translateY(20px); transition:all 1s ease;">
        <div class="card-body">
          <h5 class="fw-bold mb-2">🌞 Today's Nutrition Tip</h5>
          <p class="mb-0"><?= $dailyTip ?></p>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const tipBox = document.getElementById('daily-tip');
  setTimeout(() => {
    tipBox.style.opacity = '1';
    tipBox.style.transform = 'translateY(0)';
  }, 200);
});
</script>

<style>
.floating-icon {
  position: absolute;
  top: -15px;
  right: -15px;
  font-size: 1.2rem;
  opacity: 0.8;
  animation: float 2s ease-in-out infinite;
}
@keyframes float {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-4px); }
}
.meal-card .meal-emoji {
  position: relative;
}
</style>



    <!-- 👤 Profile Section -->
    <section id="profile" class="section">
      <div class="card mx-auto shadow-sm p-4" style="max-width:500px;">
        <h3 class="text-center mb-3">Your Profile</h3>
        <form action="save_profile.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($profile['name'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($profile['dob'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Height (cm)</label>
            <input type="number" name="height" class="form-control" value="<?= htmlspecialchars($profile['height'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Weight (kg)</label>
            <input type="number" name="weight" class="form-control" value="<?= htmlspecialchars($profile['weight'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Region</label>
            <select name="region" class="form-select" required>
              <option value="">--Select Your Region--</option>
              <option value="North-karnataka" <?= ($profile['region'] ?? '') === 'North-karnataka' ? 'selected' : '' ?>>North Karnataka</option>
              <option value="South-karnataka" <?= ($profile['region'] ?? '') === 'South-karnataka' ? 'selected' : '' ?>>South Karnataka</option>
              <option value="East-karnataka" <?= ($profile['region'] ?? '') === 'East-karnataka' ? 'selected' : '' ?>>East Karnataka</option>
              <option value="West-karnataka" <?= ($profile['region'] ?? '') === 'West-karnataka' ? 'selected' : '' ?>>West Karnataka</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Save Profile</button>
        </form>
      </div>
    </section>

    <div class="water-reminder">
      <div class="reminder-card">
        <img src="images/water.png" alt="Water Glass" class="water-icon" />
        <h2>Time to Drink Water! 💧</h2>
        <p>Keep yourself hydrated for a healthy body.</p>
        <button onclick="dismissReminder()">Got it!</button>
      </div>
    </div>

  </main>

  <script>
    const userAge = <?= json_encode($userAge); ?>;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="user_script.js"></script>
</body>
</html>
