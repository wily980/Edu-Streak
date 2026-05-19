<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Quest</title>
  <link rel="stylesheet" href="DailyQuest.css">
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
          <img src="/public/tes-punya-kwn/Assets/boxicons_home-filled.png" alt="" class="nav-box-icon">
          <span class="nav-label">Home</span>
        </div>

        <div class="nav-item">
          <img src="/public/tes-punya-kwn/Assets/ph_code-fill.png" alt="" class="nav-box-icon">
          <span class="nav-label">Progress</span>
        </div>

        <div class="nav-item">
          <img src="/public/tes-punya-kwn/Assets/ri_trophy-fill.png" alt="" class="nav-box-icon">
          <span class="nav-label">Score</span>
        </div>

        <div class="nav-item">
          <img src="/public/tes-punya-kwn/Assets/streamline-ultimate_treasure-chest-bold.png" alt=""
            class="nav-box-icon">
          <span class="nav-label">Quest</span>
        </div>

        <div class="nav-item">
          <img src="/public/tes-punya-kwn/Assets/solar_shop-bold.png" alt="" class="nav-box-icon">
          <span class="nav-label">Shop</span>
        </div>

        <div class="nav-item active">
          <img src="/public/tes-punya-kwn/Assets/iconamoon_profile-fill.png" alt="" class="nav-box-icon">
          <span class="nav-label">Profile</span>
        </div>

        <div class="nav-item">
          <img src="/public/tes-punya-kwn/Assets/basil_other-1-outline.png" alt="" class="nav-box-icon">
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

    <!-- MAIN -->
    <div class="main-wrapper">

      <!-- TOPBAR -->
      <header class="topbar">

        <div class="topbar-items">

          <div class="topbar-item html5">
            <img src="public/tes-punya-kwn/Assets/icon-html.png" alt="" class="html5-icon">
          </div>

          <div class="topbar-item streak">
            <img src="public/tes-punya-kwn/Assets/streak-black.png" alt="" class="streakblack-icon">
            <span class="streak-count">0</span>
          </div>

          <div class="topbar-item coins">
            <img src="public/tes-punya-kwn/Assets/coin.png" alt="" class="coin-icon">
            <span class="coin-count">500</span>
          </div>

          <div class="topbar-item hearts">
            <img src="public/tes-punya-kwn/Assets/icon-heart.png" alt="" class="heartfull-icon">
          </div>

        </div>

      </header>

      <!-- CENTER CONTENT -->
      <div class="center-content">

        <!-- LEFT CONTENT -->
        <div class="left-content">

          <!-- WELCOME -->
          <div class="welcome-banner">

            <div class="welcome-text">
              <h1>Welcome!</h1>

              <p>
                Complete missions to earn rewards!
                <br>
                Missions Reset daily.
              </p>
            </div>

            <img src="public/tes-punya-kwn/Assets/welcome-bannerrobot.png" alt="">

          </div>

          <!-- DAILY QUEST -->
          <div class="daily-quest">

            <div class="title-top">

              <h1>Daily Quest</h1>

              <div class="right-title-top">
                <img src="public/tes-punya-kwn/Assets/svg-spinners_clock.png" alt="">
                <h2>1 hour</h2>
              </div>

            </div>

            <!-- AVAILABLE QUEST -->
            <div class="available-quest">

              <div class="quest-icon">
                <img src="public/tes-punya-kwn/Assets/petir.png" alt="" class="quest-icon-img">
              </div>

              <div class="quest-content">

                <h3>Keep up with your streak 20 times</h3>

                <div class="progress-wrapper">

                  <div class="progress-track"></div>

                  <img
                    src="public/tes-punya-kwn/Assets/streamline-ultimate_treasure-chest-bold.png"
                    alt=""
                    class="chest-icon">

                </div>

              </div>

            </div>

            <!-- LOCKED QUEST -->
            <div class="locked-quest">

              <div class="quest-icon">
                <img src="public/tes-punya-kwn/Assets/Vector.png" alt="" class="quest-icon-img">
              </div>

              <div class="quest-content">
                <h3>Complete the one on top first</h3>
              </div>

            </div>

          </div>

        </div>

        <!-- MONTHLY CHALLENGE -->
        <div class="monthly-challenge">

          <h2>
            Monthly challenges
            <br>
            will be open soon!
          </h2>

          <p>
            Complete monthly challenges to earn exclusive badges.
          </p>

          <img
            src="public/tes-punya-kwn/Assets/Coinkuninghijau.png"
            alt=""
            class="monthly-badge">

        </div>

      </div>

    </div>

  </div>

  <script src="DailyQuest.js"></script>

</body>

</html>