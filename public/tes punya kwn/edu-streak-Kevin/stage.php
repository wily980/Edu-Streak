<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Life - Learning App</title>
  <link rel="stylesheet" href="stage.css" />
  <link href="" rel="stylesheet"/>
</head>
<body>

  <!-- LAYOUT ROOT -->
  <div class="app-root">

    <!-- Sidebar (no overflow hidden, arrow is a sibling) -->
    <aside class="sidebar" id="sidebar">
      <div class="logo">
        <img src="../../tes punya kwn/Assets/Logoutama.png" alt="Logo" class="logo-img">
      </div>
        <nav class="nav-items">
        <div class="nav-item active">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Home</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Progress</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Score</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Quest</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Shop</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Profile</span>
        </div>
        <div class="nav-item">
          <img src="../../tes punya kwn/Assets/icon-box.png" alt="box" class="nav-box-icon">
          <span class="nav-label">Other</span>
        </div>
      </nav>
    </aside>

    <!-- Arrow button: OUTSIDE sidebar, attached to its right edge -->
    <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle sidebar">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="arrowSvg" class="arrow-svg">
        <polyline points="9 18 15 12 9 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

      <!-- Top Bar -->
      <header class="topbar">
        <div class="topbar-items">
          <div class="topbar-item html5">
            <img src="../../tes punya kwn/Assets/icon-html.png" alt="html" class="html5-icon">
          </div>
          <div class="topbar-item streak">
            <img src="../../tes punya kwn/Assets/streak-black.png" alt="streak" class="streakblack-icon">
            <span class="streak-count">0</span>
          </div>
          <div class="topbar-item coins">
            <img src="../../tes punya kwn/Assets/coin.png" alt="coin" class="coin-icon">
            <span class="coin-count">500</span>
          </div>
          <div class="topbar-item hearts">
            <img src="../../tes punya kwn/Assets/icon-heart.png" alt="heartfull" class="heartfull-icon">
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <div class="content-area">

        <!-- Left Panel -->
        <div class="left-panel">
          <div class="container">

    <!-- Dots -->
    <div class="dot" style="top:130px; left:380px;"></div>
    <div class="dot" style="top:160px; left:355px;"></div>
    <div class="dot" style="top:180px; left:320px;"></div>

    <div class="dot" style="top:210px; left:150px;"></div>
    <div class="dot" style="top:240px; left:130px;"></div>
    <div class="dot" style="top:275px; left:130px;"></div>

    <div class="dot" style="top:440px; left:130px;"></div>
    <div class="dot" style="top:480px; left:140px;"></div>
    <div class="dot" style="top:500px; left:170px;"></div>

    <div class="dot" style="top:600px; left:250px;"></div>
    <div class="dot" style="top:630px; left:220px;"></div>
    <div class="dot" style="top:630px; left:180px;"></div>

    <!-- Levels -->
     <a href="" >
    <div class="level l1">
      <div class="stage">☆</div>
    </div>
    </a>

    <a href="" >
    <div class="level-lock l2">
      <div class="stage">🔒︎</div>
    </div>
    </a>

    <a href="" >
    <div class="level-lock l3">
      <div class="stage">🔒︎</div>
    </div>
    </a>

    <a href="" >
    <div class="level-lock l4">
      <div class="stage">🔒︎</div>
    </div>
    </a>

    <a href="" >
    <div class="level-lock l5">
      <div class="stage">🔒︎</div>
    </div>
    </a>   

        </div>

        <!-- Right Panel -->
        <aside class="right-panel" id="right-panel">

          <!-- Today's Quest -->
          <div class="quest-card">
            <h3 class="quest-title">Your Quest for today!</h3>
            <div class="quest-body">
              <div class="quest-lock">
                <img src="../../tes punya kwn/Assets/Vector.png" alt="Lock">
              </div>
              <p class="quest-desc">Complete 2 of this question</p>
            </div>
          </div>

          <!-- Extra Quest -->
          <div class="quest-card extra-quest-card">
            <div class="extra-quest-header">
              <h3 class="quest-title">Extra Quest</h3>
              <a href="#" class="lihat-semua">Lihat semua</a>
            </div>
            <div class="quest-body extra-body">
              <div class="bolt-icon">
                <img src="../../tes punya kwn/Assets/petir.png" alt="petir">
              </div>
              <div class="extra-info">
                <p class="extra-desc">Keep up with your streak 20 times</p>
                <div class="progress-row">
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: 0%"></div>
                  </div>
                  <span class="progress-label">0/20</span>
                  <div class="chest-icon">
                    <svg viewBox="0 0 40 34" xmlns="http://www.w3.org/2000/svg" class="chest-svg">
                      <rect x="0" y="10" width="40" height="24" rx="4" fill="#4a5568"/>
                      <rect x="0" y="10" width="40" height="10" rx="2" fill="#5a6a7e"/>
                      <rect x="14" y="14" width="12" height="10" rx="3" fill="#888"/>
                      <rect x="17" y="16" width="6" height="6" rx="2" fill="#aaa"/>
                      <rect x="0" y="0" width="40" height="12" rx="4" fill="#6b7a90"/>
                      <rect x="14" y="2" width="12" height="8" rx="2" fill="#7a8a9f"/>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Profile Prompt -->
          <div class="quest-card profile-card">
            <p class="profile-text">Make your profile to keep your streak!</p>
            <button class="btn btn-green">Make profile</button>
            <button class="btn btn-blue">Sign in</button>
          </div>

        </aside>

      
            <!-- Arrow button: OUTSIDE sidebar, attached to its right edge -->
    <button class="sidebar2-arrow" id="sidebar2Arrow" aria-label="Toggle sidebar2">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="arrow2Svg" class="arrow2-svg">
        <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>


      </div>
    </div>
  </div>



  <script src="stage.js"></script>
</body>
</html>