<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Life - Learning App</title>
  <link rel="stylesheet" href="leaderboard.css" />
  
</head>
<body>

  <!-- LAYOUT -->
  <div class="app-root">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="logo">
        <img src="../../assets/Logoutama.png" alt="Logo" class="logo-img">
      </div>
      <nav class="nav-items">
        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Home</span>
        </div>
        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Progress</span>
        </div>
        <div class="nav-item active">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Score</span>
        </div>
        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Quest</span>
        </div>
        <a href="shop.php" class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Shop</span>
        </a>
        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Profile</span>
        </div>
        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Other</span>
        </div>
      </nav>
    </aside>

    <!--Arrow button-->
    <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle sidebar">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="arrowSvg" class="arrow-svg">
        <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
 
      <!-- CENTER PANEL -->
      <div class="center-panel">
 
        <!-- Medal Group -->
        <div class="medal-group">
          <span class="sparkle sparkle-1">✦</span>
          <span class="sparkle sparkle-2">✦</span>
          <span class="sparkle sparkle-3">✦</span>
          <img src="../../assets/leaderboard-icon.png" alt="Medals" class="medal-combined">
        </div>
 
        <!-- Title -->
        <h1 class="score-title">Look at your score</h1>
        <p class="score-subtitle">for this month and<br/>compare it with the other</p>
 
        <!-- Leaderboard -->
        <div class="leaderboard">
 
          <div class="lb-row">
            <div class="lb-dot skeleton"></div>
            <div class="lb-avatar skeleton"></div>
            <div class="lb-name skeleton" style="width: 180px;"></div>
            <div class="lb-score skeleton" style="width: 80px;"></div>
          </div>
          <hr class="lb-divider">
 
          <div class="lb-row">
            <div class="lb-dot skeleton"></div>
            <div class="lb-avatar skeleton"></div>
            <div class="lb-name skeleton" style="width: 210px;"></div>
            <div class="lb-score skeleton" style="width: 64px;"></div>
          </div>
          <hr class="lb-divider">
 
          <div class="lb-row">
            <div class="lb-dot skeleton"></div>
            <div class="lb-avatar skeleton"></div>
            <div class="lb-name skeleton" style="width: 120px;"></div>
            <div class="lb-score skeleton" style="width: 80px;"></div>
          </div>
          <hr class="lb-divider">
 
          <div class="lb-row">
            <div class="lb-dot skeleton"></div>
            <div class="lb-avatar skeleton"></div>
            <div class="lb-name skeleton" style="width: 260px;"></div>
            <div class="lb-score skeleton" style="width: 64px;"></div>
          </div>
        </div>
      </div>
 
      <!-- RIGHT PANEL -->
      <aside class="right-panel">
        <div class="info-card">
          <p class="info-label">How Does this page works?</p>
          <h2 class="info-title">Learn, Compete, and use your exp</h2>
          <p class="info-desc">
            Reach the highest score as possible this month and compare it with your previous month
          </p>
          <img src="../../assets/robot-image.png" alt="Robot" class="robot-img">
        </div>
      </aside>
    </div>     
  </div>

  <script src="leaderboard.js"></script>
</body>
</html>