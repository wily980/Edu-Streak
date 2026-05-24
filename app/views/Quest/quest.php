<?php
// app/views/Quest/quest.php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quest - EduStreak</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/quest.css"/>
</head>
<body>
<div class="app-root">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>/assets/Logoutama.png" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-items">
        <?php
        $homeHref = isset($_SESSION['last_lang'])
            ? BASE_URL . '/level?lang=' . $_SESSION['last_lang']
            : BASE_URL . '/level';
        $navLinks = [
            ['label' => 'Home',        'href' => $homeHref,                        'icon' => 'home.png'],
            ['label' => 'History',        'href' => BASE_URL . '/History',               'icon' => 'history.png'],
            ['label' => 'Leaderboard', 'href' => BASE_URL . '/leaderboard',        'icon' => 'trophy.png'],
            ['label' => 'Quest',       'href' => BASE_URL . '/quest',              'icon' => 'Tresure box.png'],
            ['label' => 'Shop',        'href' => BASE_URL . '/students/shop',      'icon' => 'shop.png'],
            ['label' => 'Profile',     'href' => BASE_URL . '/profile',            'icon' => 'Profile.png'],
        ];
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        foreach ($navLinks as $link):
            $slug   = str_replace(BASE_URL, '', $link['href']);
            $active = str_starts_with($currentPath, $slug) ? 'active' : '';
        ?>
        <a href="<?= htmlspecialchars($link['href']) ?>" class="nav-item <?= $active ?>">
            <img src="<?= BASE_URL ?>/assets/<?= htmlspecialchars($link['icon']) ?>" alt="<?= htmlspecialchars($link['label']) ?>" class="nav-box-icon">
            <span class="nav-label"><?= htmlspecialchars($link['label']) ?></span>
        </a>
        <?php endforeach; ?>
    </nav>
  </aside>

  <!-- SIDEBAR ARROW -->
  <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle sidebar">
    <svg viewBox="0 0 24 24" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <!-- MAIN WRAPPER -->
  <div class="main-wrapper">

    <!-- CENTER PANEL -->
    <div class="center-panel">

      <!-- Welcome banner -->
      <div class="welcome-banner">
        <div class="welcome-text">
          <h2 class="welcome-title">Welcome!</h2>
          <p class="welcome-sub">Complete missions to earn rewards!<br>Missions reset daily.</p>
        </div>
        <img src="<?= BASE_URL ?>/assets/robot 1.png" alt="Robot" class="welcome-robot">
      </div>

      <!-- Daily Quest -->
      <div class="section-header">
        <h3 class="section-title">Daily Quest</h3>
        <div class="section-timer">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <span id="resetTimer">-- hours</span>
        </div>
      </div>

      <div class="quest-list">
        <?php foreach ($dailyQuests as $i => $q): ?>
          <?php
            $pct    = $q['goal'] > 0 ? min(100, round(($q['progress'] / $q['goal']) * 100)) : 0;
            $locked = $i > 0 && !$dailyQuests[$i - 1]['done'];
          ?>
          <div class="quest-card <?= $q['done'] ? 'quest-done' : '' ?> <?= $locked ? 'quest-locked' : '' ?>">

            <?php if ($locked): ?>
              <!-- Locked state -->
              <div class="quest-lock-icon">
                <img src="<?= BASE_URL ?>/assets/Vector.png" alt="Locked">
              </div>
              <div class="quest-info">
                <p class="quest-locked-label">Complete the one on top first</p>
              </div>

            <?php else: ?>
              <!-- Active / done state -->
              <div class="quest-icon <?= $q['done'] ? 'icon-done' : '' ?>">
                <?php if ($q['done']): ?>
                  <span class="checkmark">✓</span>
                <?php else: ?>
                  <img src="<?= BASE_URL ?>/assets/<?= $q['icon'] ?>.png" alt="quest icon">
                <?php endif; ?>
              </div>

              <div class="quest-info">
                <p class="quest-title-text"><?= htmlspecialchars($q['title']) ?></p>
                <div class="quest-progress-row">
                  <div class="quest-progress-track">
                    <div class="quest-progress-fill" style="width: <?= $pct ?>%"></div>
                  </div>
                  <div class="quest-reward-icon">
                    <img src="<?= BASE_URL ?>/assets/coin.png" alt="reward" class="reward-gem">
                  </div>
                </div>
                <span class="quest-progress-label"><?= $q['progress'] ?>/<?= $q['goal'] ?></span>
              </div>

              <?php if ($q['done']): ?>
                <div class="quest-badge-done">Done!</div>
              <?php endif; ?>

            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

    </div>

    <!-- RIGHT PANEL -->
    <aside class="right-panel">

      <!-- Topbar stats -->
      <div class="topbar-items">
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/streak-black.png" alt="streak" class="streakblack-icon">
          <span><?= $streak ?></span>
        </div>
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/coin.png" alt="gems" class="coin-icon">
          <span><?= $gems ?></span>
        </div>
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/icon-heart.png" alt="hearts" class="heartfull-icon">
          <span><?= $hearts ?>/5</span>
        </div>
      </div>

      <!-- Monthly challenges coming soon card -->
      <div class="monthly-card">
        <div class="monthly-sparkle sparkle-1">✦</div>
        <div class="monthly-sparkle sparkle-2">✦</div>
        <div class="monthly-text">
          <h3 class="monthly-title">Monthly challenges<br>will be open soon!</h3>
          <p class="monthly-sub">Complete monthly challenges to earn exclusive badges.</p>
        </div>
        <img src="<?= BASE_URL ?>/assets/coin.png" alt="badge" class="monthly-coin">
      </div>

      <!-- Monthly quest list -->
      <div class="section-header" style="margin-top: 1.2rem;">
        <h3 class="section-title">Monthly Quest</h3>
      </div>

      <div class="quest-list">
        <?php foreach ($monthlyQuests as $q): ?>
          <?php $pct = $q['goal'] > 0 ? min(100, round(($q['progress'] / $q['goal']) * 100)) : 0; ?>
          <div class="quest-card <?= $q['done'] ? 'quest-done' : '' ?>">
            <div class="quest-icon <?= $q['done'] ? 'icon-done' : '' ?>">
              <?php if ($q['done']): ?>
                <span class="checkmark">✓</span>
              <?php else: ?>
                <img src="<?= BASE_URL ?>/assets/<?= $q['icon'] ?>.png" alt="quest icon">
              <?php endif; ?>
            </div>
            <div class="quest-info">
              <p class="quest-title-text"><?= htmlspecialchars($q['title']) ?></p>
              <div class="quest-progress-row">
                <div class="quest-progress-track">
                  <div class="quest-progress-fill" style="width: <?= $pct ?>%"></div>
                </div>
                <div class="quest-reward-icon">
                  <img src="<?= BASE_URL ?>/assets/coin.png" alt="reward" class="reward-gem">
                </div>
              </div>
              <span class="quest-progress-label"><?= $q['progress'] ?>/<?= $q['goal'] ?></span>
            </div>
            <?php if ($q['done']): ?>
              <div class="quest-badge-done">Done!</div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

    </aside>
  </div>
</div>

<script src="<?= BASE_URL ?>/js/quest.js"></script>
</body>
</html>