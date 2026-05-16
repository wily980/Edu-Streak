<!-- profile.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Dashboard</title>

  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="profile.css">
</head>
<body>

  <div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

      <div class="logo">
        <img src="img/logo.png" alt="">
      </div>

      <div class="menu">

        <div class="menu-box active">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

        <div class="menu-box">
          <img src="img/box.png" alt="">
        </div>

      </div>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

      <!-- PROFILE CARD -->
      <section class="profile-section">

        <div class="banner">

          <button class="edit-btn">
            <img src="img/edit.png" alt="">
          </button>

          <div class="profile-photo">
            <img src="img/profile.png" alt="">
          </div>

        </div>

        <div class="profile-info">

          <h1>Wily Sepiro</h1>

          <p class="username">Wily Sepiro</p>

          <p class="join-date">Joined at April 2026</p>

          <div class="follow-info">
            <span>Follower 0</span>
            <span>Following 0</span>
          </div>

        </div>

        <div class="divider"></div>

        <h2 class="stat-title">Statistik</h2>

        <div class="stats-grid">

          <div class="stat-box"></div>
          <div class="stat-box"></div>
          <div class="stat-box"></div>
          <div class="stat-box"></div>

        </div>

      </section>

      <!-- RIGHT SIDE -->
      <aside class="right-panel">

        <!-- TOP ICON -->
        <div class="top-icons">

          <div class="top-item">
            <img src="img/html.png" alt="">
          </div>

          <div class="top-item fire">
            <img src="img/fire.png" alt="">
            <span>0</span>
          </div>

          <div class="top-item coin">
            <img src="img/coin.png" alt="">
            <span>500</span>
          </div>

          <div class="top-item">
            <img src="img/heart.png" alt="">
          </div>

        </div>

        <!-- QUEST -->
        <div class="card">

          <h3>Your Quest for today!</h3>

          <div class="quest-content">

            <img src="img/lock.png" alt="">

            <p>Complete 2 of this question</p>

          </div>

        </div>

        <!-- EXTRA QUEST -->
        <div class="card">

          <div class="card-head">

            <h3>Extra Quest</h3>

            <a href="#">Lihat semua</a>

          </div>

          <div class="extra-box">

            <img src="img/lightning.png" alt="">

            <div class="progress-content">

              <p>Keep up with your streak 20 times</p>

              <div class="progress-bar">
                <div class="progress"></div>
              </div>

              <span>0/20</span>

            </div>

            <img class="chest" src="img/chest.png" alt="">

          </div>

        </div>

        <!-- LOGIN -->
        <div class="card login-card">

          <h3>Make your profile to keep your streak!</h3>

          <button class="green-btn">Make profile</button>

          <button class="blue-btn">Sign in</button>

        </div>

      </aside>

    </main>

  </div>

</body>
</html>