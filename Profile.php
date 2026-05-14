<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Life - Learning App</title>

  <link rel="stylesheet" href="Profile.css" />
</head>

<body>

  <div class="app-root">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

      <div class="logo">
        <img src="/public/tes-punya-kwn/Assets/Logoutama.png" alt="Logo" class="logo-img">
      </div>

      <nav class="nav-items">

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Home</span>
        </div>

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Progress</span>
        </div>

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Score</span>
        </div>

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Quest</span>
        </div>

        <div class="nav-item active">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Shop</span>
        </div>

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Profile</span>
        </div>

        <div class="nav-item">
          <img src="../../assets/icon-box.png" alt="" class="nav-box-icon">
          <span class="nav-label">Other</span>
        </div>

      </nav>

    </aside>

    <!-- TOGGLE BUTTON -->
    <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle Sidebar">

      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="arrow-svg" id="arrowSvg">
        <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"
          stroke-linejoin="round" />

      </svg>

    </button>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

      <!-- TOPBAR -->
      <header class="topbar">

        <div class="topbar-items">

          <div class="topbar-item html5">
            <img src="public/tes-punya-kwn/assets/icon-html.png" alt="" class="html5-icon">
          </div>

          <div class="topbar-item streak">
            <img src="public/tes-punya-kwn/assets/streak-black.png" alt="" class="streakblack-icon">
            <span class="streak-count">0</span>
          </div>

          <div class="topbar-item coins">
            <img src="public/tes-punya-kwn/assets/coin.png" alt="" class="coin-icon">
            <span class="coin-count">500</span>
          </div>

          <div class="topbar-item hearts">
            <img src="public/tes-punya-kwn/assets/icon-heart.png" alt="" class="heartfull-icon">
          </div>

        </div>

      </header>

      <!-- CONTENT -->
      <div class="container">

        <!-- MAIN CONTENT -->
        <main class="main-content">

          <!-- PROFILE -->
          <section class="profile-section">

            <!-- BANNER -->
            <div class="banner">

              <button class="edit-btn">
                <img src="../../assets/edit.png" alt="">
              </button>

              <div class="profile-photo">
                <img src="../../assets/profile.png" alt="">
              </div>

            </div>

            <!-- PROFILE INFO -->
            <div class="profile-info">

              <h1>Wily Sepiro</h1>

              <p class="username">@wilysepiro</p>

              <p class="join-date">
                Joined at April 2026
              </p>

            <div class="below-join-date">
              <div class="follow-info">
                <span>Follower 0</span>
                <span>Following 0</span>
              </div>

              <img src="public/tes-punya-kwn/Assets/python.png" alt="">

            </div>

            </div>

            <!-- DIVIDER -->
            <div class="divider"></div>

            <!-- STAT -->
            <h2 class="stat-title">Statistik</h2>

            <div class="stats-grid">

              <div class="stat-box"></div>
              <div class="stat-box"></div>
              <div class="stat-box"></div>
              <div class="stat-box"></div>

            </div>

          </section>

        </main>

        <!-- RIGHT PANEL -->
        <aside class="right-panel">

          <!-- TODAY QUEST -->
          <div class="quest-card">

            <h3 class="quest-title">
              Your Quest for today!
            </h3>

            <div class="quest-body">

              <div class="quest-lock">
                <img src="/public/tes-punya-kwn/Assets/Vector.png" alt="">
              </div>

              <p class="quest-desc">
                Complete 2 of this question
              </p>

            </div>

          </div>

          <!-- EXTRA QUEST -->
          <div class="quest-card extra-quest-card">

            <div class="extra-quest-header">

              <h3 class="quest-title">
                Extra Quest
              </h3>

              <a href="#" class="lihat-semua">
                Lihat semua
              </a>

            </div>

            <div class="quest-body extra-body">

              <div class="bolt-icon">
                <img src="/public/tes-punya-kwn/Assets/petir.png" alt="">
              </div>

              <div class="extra-info">

                <p class="extra-desc">
                  Keep up with your streak 20 times
                </p>

                <div class="progress-row">

                  <div class="progress-bar-wrap">
                    <div class="progress-bar"></div>
                  </div>

                  <span class="progress-label">
                    0/20
                  </span>

                  <div class="chest-icon">

                    <svg viewBox="0 0 40 34" xmlns="http://www.w3.org/2000/svg" class="chest-svg">

                      <rect x="0" y="10" width="40" height="24" rx="4" fill="#4a5568" />
                      <rect x="0" y="10" width="40" height="10" rx="2" fill="#5a6a7e" />
                      <rect x="14" y="14" width="12" height="10" rx="3" fill="#888" />
                      <rect x="17" y="16" width="6" height="6" rx="2" fill="#aaa" />
                      <rect x="0" y="0" width="40" height="12" rx="4" fill="#6b7a90" />
                      <rect x="14" y="2" width="12" height="8" rx="2" fill="#7a8a9f" />

                    </svg>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <!-- PROFILE CARD -->
          <div class="quest-card profile-card">

            <p class="profile-text">
              Make your profile to keep your streak!
            </p>

            <button class="btn btn-green">
              Make profile
            </button>

            <button class="btn btn-blue">
              Sign in
            </button>

          </div>

        </aside>

      </div>

    </div>

  </div>

  <script src="Profile.js"></script>

</body>

</html>