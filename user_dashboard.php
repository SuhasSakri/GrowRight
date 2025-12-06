<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("user_dashboard_php.php");
include("update_streak.php");
include("update_water.php");

$userAge = null;

if (!empty($profile['dob'])) {
    $dob = new DateTime($profile['dob']);
    $todayObj = new DateTime();
    $userAge = $dob->diff($todayObj)->y;
}

$nutritionTips = [];

if ($profile && $userAge !== null) {
    $region = $profile['region'] ?? '';

    if ($userAge >= 3 && $userAge <= 5)       $ageCategory = '3-5';
    elseif ($userAge >= 6 && $userAge <= 9)   $ageCategory = '6-9';
    elseif ($userAge >= 10 && $userAge <= 13) $ageCategory = '10-13';
    else                                      $ageCategory = null;

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
                'Lunch'  => 'Vegetables, legumes, moderate protein',
                'Snack'  => 'Fruits, sprouts, or nuts',
                'Dinner' => 'Balanced meal with vegetables and protein'
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
                'Breakfast' => 'Rice with curd or coconut dishes',
                'Lunch' => 'Rice, lentils, vegetables',
                'Snack' => 'Fruits or sprouts',
                'Dinner' => 'Balanced rice meal with vegetables and protein'
            ],
            '10-13' => [
                'Breakfast' => 'Rice or ragi porridge with milk',
                'Lunch' => 'Rice with vegetables, legumes, protein',
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
                'Lunch' => 'Lentils, vegetables, rice/roti',
                'Snack' => 'Sprouts or fruits',
                'Dinner' => 'Vegetable curry with jowar roti'
            ],
            '10-13' => [
                'Breakfast' => 'Jowar roti or porridge with milk',
                'Lunch' => 'Jowar, vegetables, legumes, protein',
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
                'Lunch' => 'Legumes, vegetables, rice/roti',
                'Snack' => 'Fruits or nuts',
                'Dinner' => 'Vegetable curry with roti or rice'
            ],
            '10-13' => [
                'Breakfast' => 'Ragi porridge or roti with milk',
                'Lunch' => 'Vegetables, legumes, protein foods',
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
            'Lunch' => 'Vegetables with rice/roti',
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
    body { 
      background: linear-gradient(135deg, #A7EBF2 0%, #54ACBF 25%, #26658C 50%, #023859 75%, #011C40 100%);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      min-height: 100vh;
      position: relative;
    }
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.92);
      z-index: -1;
    }
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .navbar-brand { font-size: 1.5rem; }
    .section { display: none; }
    .section.active { display: block; }
    .card { 
      border-radius: 20px;
      backdrop-filter: blur(10px);
      background: rgba(255,255,255,0.95) !important;
      border: 1px solid rgba(255,255,255,0.3);
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
    }
    .table th { width: 40%; }
    .btn-primary { 
      background: linear-gradient(135deg, #26658C, #023859) !important;
      border: none !important;
      font-weight: 600;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #023859, #011C40) !important;
    }
    .btn-success { 
      background: linear-gradient(135deg, #54ACBF, #26658C) !important;
      border: none !important;
      font-weight: 600;
    }
    .tab-link.active { 
      font-weight: bold; 
      background: rgba(167,235,242,0.3) !important;
      transform: translateY(-2px);
    }
    .tab-link:hover {
      background: rgba(167,235,242,0.15);
      transform: translateY(-2px);
    }
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

.div1 {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
    background: linear-gradient(135deg, #26658C 0%, #023859 100%);
    border-radius: 25px;
    box-shadow: 0 15px 40px rgba(38,101,140,0.4);
    text-align: center;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.div1::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(167,235,242,0.15) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}
@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.div1 h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 10px;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    animation: fadeInDown 1s ease;
    position: relative;
    z-index: 1;
}

.div1 p {
    color: #f0f0f0;
    font-size: 1.1rem;
    margin: 0;
    animation: fadeIn 1.5s ease;
    position: relative;
    z-index: 1;
}

.div1:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(38,101,140,0.5);
}

@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-20px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
  .meal-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 12px 25px rgba(0,0,0,0.3);
  }

  .meal-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

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

  .meal-emoji { display:inline-block; transition: transform 0.6s ease, opacity 0.6s ease; opacity:0; }
  .meal-emoji.visible { transform: translateY(-10px) rotate(-10deg); opacity:1; }

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
  background: linear-gradient(135deg, #54ACBF, #26658C);
  color: white;
  font-weight: 600;
  font-size: 1.1rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-gradient-physical:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(38,101,140, 0.4);
}

.btn-gradient-mental {
  background: linear-gradient(135deg, #A7EBF2, #54ACBF);
  color: #023859;
  font-weight: 600;
  font-size: 1.1rem;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-gradient-mental:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(84,172,191, 0.4);
}

.activity-btn {
  border-radius: 15px;
}

.modal-content {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px);}
  100% { opacity: 1; transform: translateY(0);}
}

.btn-text {
  display: inline-block;
  transition: transform 0.3s;
}
.activity-btn:hover .btn-text {
  transform: scale(1.05);
}
 .streak-fire { font-size:1.5rem; animation: flicker 1.5s infinite alternate; }
.streak-empty { font-size:1.5rem; opacity:0.3; }

@keyframes flicker {
  0%,100% { transform: scale(1); }
  50% { transform: scale(1.2); }
}

.div5 {
    grid-column: 1 / -1;
    padding: 20px;
}

.achievements-card {
    background: linear-gradient(135deg, #fff9e6, #fffbf0);
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    border: 2px solid rgba(255,193,7,0.2);
}

.achievements-card h4 {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #ffb347;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}

.achievements-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.achievement-card {
    background: linear-gradient(135deg, #fff3d6, #ffe8b3);
    border-radius: 18px;
    padding: 20px;
    width: 190px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
    border: 2px solid rgba(255,152,0,0.2);
}

.achievement-card.unlocked {
    background: linear-gradient(135deg, #d4f5d4, #c8e6c9);
    border-color: rgba(76,175,80,0.3);
    box-shadow: 0 8px 25px rgba(76,175,80,0.2);
}

.achievement-card .emoji {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 10px;
    animation: bounce 1.2s infinite;
}

.achievement-card h5 {
    font-size: 1.1rem;
    margin: 5px 0;
    color: #ff8c42;
}

.achievement-card p {
    font-size: 0.9rem;
    color: #555;
    margin: 0 0 8px 0;
}

.achievement-card small {
    font-size: 0.8rem;
    color: #888;
}

.achievement-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.text-gradient {
  background: linear-gradient(45deg, #023859, #26658C, #54ACBF, #A7EBF2);
  -webkit-background-clip: text;
  color: transparent;
}

.activity-card {
  background: linear-gradient(135deg, #54ACBF, #26658C);
  border-radius: 25px;
  padding: 50px 25px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;
  cursor: pointer;
  text-align: center;
  position: relative;
  overflow: hidden;
  color: #fff;
  box-shadow: 0 4px 15px rgba(38,101,140, 0.2),
              inset 0 0 15px rgba(167,235,242, 0.2);
}

.activity-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 25px 40px rgba(0, 0, 0, 0.18),
              inset 0 0 15px rgba(255, 255, 255, 0.3);
}

.activity-card::before {
  content: "";
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    120deg,
    rgba(255, 255, 255, 0.05) 0%,
    rgba(255, 255, 255, 0.15) 50%,
    rgba(255, 255, 255, 0.05) 100%
  );
  transform: rotate(25deg);
  transition: all 0.5s ease;
  pointer-events: none;
  z-index: -1;
}

.activity-card:hover::before {
  animation: shimmer 1.2s linear infinite;
}

@keyframes shimmer {
  0% { transform: translateX(-100%) rotate(25deg); }
  100% { transform: translateX(100%) rotate(25deg); }
}

.icon-circle {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  font-size: 45px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 20px auto;
  color: white;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25),
              inset 0 0 8px rgba(255, 255, 255, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  z-index: 1;
}

.activity-card:hover .icon-circle {
  transform: scale(1.15);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25),
              inset 0 0 10px rgba(255, 255, 255, 0.25);
}

.bg-physical {
  background: linear-gradient(135deg, #54ACBF, #26658C);
  background-blend-mode: overlay;
  position: relative;
}

.bg-physical::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: url('https://www.transparenttextures.com/patterns/asfalt-light.png') repeat;
  opacity: 0.08;
  border-radius: 50%;
  pointer-events: none;
}

.bg-mental {
  background: linear-gradient(135deg, #A7EBF2, #54ACBF);
  background-blend-mode: overlay;
  position: relative;
}

.bg-mental::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: url('https://www.transparenttextures.com/patterns/cubes.png') repeat;
  opacity: 0.08;
  border-radius: 50%;
  pointer-events: none;
}

.activity-title {
  font-size: 21px;
  font-weight: 600;
  color: #333;
  position: relative;
  z-index: 1;
  text-shadow: 0 1px 2px rgba(255,255,255,0.2);
}

.btn-back {
  background: #f1f1f1;
  border-radius: 12px;
  padding: 8px 18px;
}

.btn-back:hover {
  background: #e0e0e0;
}

.enhanced-list .list-group-item {
  border-radius: 12px !important;
  margin-bottom: 10px;
  padding: 15px;
  font-size: 17px;
  transition: transform 0.25s ease, background 0.25s ease;
  cursor: pointer;
  position: relative;
  z-index: 10;
}

.enhanced-list .list-group-item:hover {
  background: #f9f9f9;
  transform: translateX(6px);
}

.fade-in {
  animation: fadeIn 0.4s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-header-custom {
  background: linear-gradient(135deg, #26658C, #54ACBF, #A7EBF2);
  color: white;
  border-radius: 12px 12px 0 0;
}

.info-modal {
  border-radius: 15px;
  overflow: hidden;
}

.modal-backdrop {
  display: none !important;
}

.modal {
  z-index: 1050 !important;
  pointer-events: auto !important;
}

.modal-content {
  pointer-events: auto !important;
}

#aiChatWidget {
  z-index: 10000 !important;
}


</style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #023859, #011C40); box-shadow: 0 4px 12px rgba(1,28,64,0.3);">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#" style="font-size: 1.8rem; letter-spacing: 1px;">GrowRight</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav gap-2">
          <li class="nav-item"><a class="nav-link active tab-link px-3" data-tab="dashboard" href="#" style="border-radius: 8px; transition: all 0.3s;">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link tab-link px-3" data-tab="routines" href="#" style="border-radius: 8px; transition: all 0.3s;">Routines</a></li>
          <li class="nav-item"><a class="nav-link tab-link px-3" data-tab="nutrition" href="#" style="border-radius: 8px; transition: all 0.3s;">Nutrition</a></li>
          <li class="nav-item"><a class="nav-link tab-link px-3" data-tab="profile" href="#" style="border-radius: 8px; transition: all 0.3s;">Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger px-3" href="logout.php" style="border-radius: 8px; background: rgba(255,255,255,0.1); transition: all 0.3s;">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

<main class="container py-5" style="position: relative; z-index: 1;">
<section id="dashboard" class="section active">
  <div class="parent" style="display:grid; grid-template-columns: repeat(5, 1fr); grid-auto-rows: minmax(150px, auto); gap:15px;">

<div class="div1">
    <h2>🌟 Welcome Back, <?= htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p style="font-size: 1.1rem; margin-top: 10px;">💪 Let's continue your health journey today</p>
    <div style="margin-top: 15px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
      <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; font-size: 0.9rem;">✨ Stay Active</span>
      <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; font-size: 0.9rem;">🥗 Eat Healthy</span>
      <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; font-size: 0.9rem;">💧 Stay Hydrated</span>
    </div>
</div>

    <?php if ($profile): ?>
    <!-- PROFILE CARD -->
    <div class="div2" style="grid-column:1 / 4; grid-row:2 / 6; padding:20px;">
      <div class="card mx-auto shadow-lg border-0" style="background: linear-gradient(135deg, #e3f2fd, #fff); border-radius:20px; padding:25px; border: 2px solid rgba(33,150,243,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
          <div style="width: 80px; height: 80px; margin: 0 auto 15px; background: linear-gradient(135deg, #2196F3, #1976D2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; box-shadow: 0 4px 15px rgba(33,150,243,0.3);">👤</div>
          <h4 class="text-primary mb-0">Your Profile Summary</h4>
        </div>
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

    <!-- STREAK CARD -->
    <?php
      $age = $userAge;
      if ($age >= 3 && $age <= 13):
        $streak = $_SESSION['streak'] ?? 0;
    ?>
    <div class="div3" style="grid-column:4 / 6; grid-row:2 / 4; padding:20px;">
      <div class="card mx-auto shadow-lg border-0" style="background: linear-gradient(135deg,#ffcc80,#ffb74d); border-radius:20px; padding:25px; text-align:center; border: 2px solid rgba(255,152,0,0.2); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <h4 class="mb-3" style="position: relative; z-index: 1;">🔥 Daily Login Streak</h4>
        <p class="fs-4 mb-1"><strong><?= $streak; ?></strong> day<?= $streak==1?'':'s'; ?> in a row!</p>
        <div class="d-flex justify-content-center gap-1 mb-2">
          <?php for ($i=1; $i<=7; $i++): ?>
            <span class="<?= $i <= $streak ? 'streak-fire' : 'streak-empty'; ?>"><?= $i <= $streak ? '🔥' : '⚪'; ?></span>
          <?php endfor; ?>
        </div>
        <p class="text-muted small">Keep your streak going to stay motivated and healthy!</p>
      </div>
    </div>
    <?php endif; ?>

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
    <div class="div4" style="grid-column:4 / 6; grid-row:4 / 6; padding:20px;">
      <div class="card mx-auto shadow-lg border-0" style="background: <?= $bmi_color; ?>; border-radius:20px; padding:25px; border: 2px solid rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
          <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.5); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">⚖️</div>
          <h4 class="mb-0">Your BMI</h4>
        </div>
        <p class="mb-0 fs-5"><strong><?= $bmi; ?></strong> - <?= $bmi_category; ?></p>
        <p class="text-muted"><?= $bmi_info; ?></p>
      </div>
    </div>
    <?php endif; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$streak        = $_SESSION['streak'] ?? 0;
$water_intake  = $_SESSION['water_intake'] ?? 0;
$achievements  = $_SESSION['achievements'] ?? [];

$allAchievements = [
    '7_day_streak'     => ['title' => '7-Day Streak',      'desc' => 'Maintain a 7-day streak!',          'threshold' => 7],
    '30_day_streak'    => ['title' => '30-Day Streak',     'desc' => 'Maintain a 30-day streak!',         'threshold' => 30],
    '5_glass_water'    => ['title' => 'Hydration Hero',    'desc' => 'Drink 5 glasses of water',          'threshold' => 5],
    '8_glass_water'    => ['title' => 'Super Hydrated',    'desc' => 'Drink 8 glasses of water',          'threshold' => 8],
    'profile_complete' => ['title' => 'Profile Complete',  'desc' => 'Complete your profile',             'threshold' => 1],
    'first_goal'       => ['title' => 'Goal Setter',       'desc' => 'Set your first health goal',        'threshold' => 1]
];

if ($streak >= 7)  $achievements['7_day_streak'] = true;
if ($streak >= 30) $achievements['30_day_streak'] = true;

if ($water_intake >= 5) $achievements['5_glass_water'] = true;
if ($water_intake >= 8) $achievements['8_glass_water'] = true;

if (
    !empty($profile['name']) &&
    !empty($profile['dob']) &&
    !empty($profile['height']) &&
    !empty($profile['weight']) &&
    !empty($profile['region'])
) {
    $achievements['profile_complete'] = true;
}

if (!empty($_SESSION['goals']) && count($_SESSION['goals']) > 0) {
    $achievements['first_goal'] = true;
}

$_SESSION['achievements'] = $achievements;
?>

<div class="div5">
  <div class="card achievements-card">
    <h4 class="text-center mb-3">🏆 Achievements</h4>
    <div class="achievements-container">
      <?php foreach($allAchievements as $key => $ach): 
        $unlocked = !empty($achievements[$key]);
        // Determine current progress
        if ($key == '7_day_streak' || $key == '30_day_streak') $current = $streak;
        elseif ($key == '5_glass_water' || $key == '8_glass_water') $current = $water_intake;
        elseif ($key == 'profile_complete' || $key == 'first_goal') $current = !empty($achievements[$key]) ? 1 : 0;
        else $current = 0;
      ?>
      <div class="achievement-card <?= $unlocked ? 'unlocked' : 'locked'; ?>">
        <span class="emoji"><?= $unlocked ? '🎉' : '🏅'; ?></span>
        <h5><?= $ach['title']; ?></h5>
        <p><?= $ach['desc']; ?></p>
        <?php if (!$unlocked): ?>
          <small class="text-muted"><?= $current . ' / ' . $ach['threshold']; ?></small>
        <?php else: ?>
          <small class="text-success">Completed! ✅</small>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>


    <?php else: ?>
      <p class="mt-3 text-muted">No profile found. Please create your profile in the <b>Profile</b> tab.</p>
    <?php endif; ?>

  </div>
</section>

<!-- 🏃‍♂️ Routines Section -->
<section id="routines" class="section text-center py-5">
  <h2 class="fw-bold mb-4 display-6 text-gradient">Choose Your Activity Type</h2>

  <div class="row justify-content-center mb-5">
    <div class="col-md-4 mb-4">
      <button class="activity-card btn px-4 py-5 w-100 shadow-lg" id="physical">
        <div class="icon-circle bg-physical mb-3">🏃‍♂️</div>
        <span class="activity-title">Physical Activities</span>
      </button>
    </div>

    <div class="col-md-4 mb-4">
      <button class="activity-card btn px-4 py-5 w-100 shadow-lg" id="mental">
        <div class="icon-circle bg-mental mb-3">🧠</div>
        <span class="activity-title">Mental Activities</span>
      </button>
    </div>
  </div>

  <div id="activityPage" class="d-none fade-in" style="position: relative; z-index: 100;">
    <button class="btn btn-back mb-3 shadow-sm" onclick="goBack()" style="position: relative; z-index: 101;">← Back</button>
    <h4 id="activityTitle" class="mb-4 fw-semibold"></h4>

    <div id="activityList" class="list-group enhanced-list" style="position: relative; z-index: 100;"></div>
  </div>

  <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content info-modal shadow-lg border-0">
        <div class="modal-header modal-header-custom">
          <h5 class="modal-title" id="infoTitle"></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4" id="infoDescription"></div>
      </div>
    </div>
  </div>
</section>


<!-- 🥗 Nutrition Section -->
<section id="nutrition" class="section text-center py-5" style="background: linear-gradient(135deg, #fdfbfb, #ebedee);">
  <h2 class="fw-bold mb-4 display-6 text-gradient">Nutrition</h2> 

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

<?php
// Show reminder only if 2 hours passed or never shown
$showWaterReminder = true;
if (isset($_SESSION['last_water_reminder'])) {
    $diff = time() - $_SESSION['last_water_reminder'];
    if ($diff < 2 * 3600) { // 2 hours = 7200 seconds
        $showWaterReminder = false;
    }
}

if ($showWaterReminder):
?>
<div class="water-reminder">
  <div class="reminder-card">
    <img src="images/water.png" alt="Water Glass" class="water-icon" />
    <h2>Time to Drink Water! 💧</h2>
    <p>Keep yourself hydrated for a healthy body.</p>
    <form method="post">
      <button type="submit" name="drink_water" onclick="dismissReminder()">Got it!</button>
    </form>
  </div>
</div>
<?php endif; ?>


  </main>

  <script>
    const userAge = <?= json_encode($userAge); ?>;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="user_script.js"></script>
  <script src="chat_widget.js"></script>
</body>
</html>
