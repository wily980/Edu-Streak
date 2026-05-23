<?php 
// app/views/level/levels.php
// Variables: $user, $language, $tracks
if (empty($user)) { header('Location: /'); exit; }

$hearts = (int)($user['hearts'] ?? 5);
$gems   = (int)($user['gems']   ?? 0);
$streak = (int)($user['streak'] ?? 0);

// Unlock logic — first track always open, next unlocks at 80%
$unlocked = [];
foreach ($tracks as $i => $track) {
    $unlocked[$track['id']] = ($i === 0) || ((float)$tracks[$i-1]['completion_pct'] >= 80);
}

// Clean zigzag — centered, well spaced, no overlaps
$positions = [
    ['top' =>  30, 'left' => 200],
    ['top' => 170, 'left' => 360],
    ['top' => 310, 'left' => 160],
    ['top' => 450, 'left' => 360],
    ['top' => 590, 'left' => 160],
    ['top' => 730, 'left' => 360],
    ['top' => 870, 'left' => 160],
    ['top' => 1010,'left' => 360],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($language['name']) ?> Levels - EduStreak</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/students.css"/>
</head>
<body>
<div class="app-root">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <img src="/Edu_Streak_Lock_in/public/assets/Logoutama.png" alt="EduStreak" class="logo-img">
    </div>
    <nav class="nav-items">
      <?php
      $navLinks = [
        ['label' => 'Home',     'href' => '/students'],
        ['label' => 'Progress', 'href' => '/students/progress'],
        ['label' => 'Score',    'href' => '/students/score'],
        ['label' => 'Quest',    'href' => '/students/quest'],
        ['label' => 'Shop',     'href' => '/students/shop'],
        ['label' => 'Profile',  'href' => '/students/profile'],
      ];
      $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      foreach ($navLinks as $link):
        $active = str_starts_with($currentPath, $link['href']) ? 'active' : '';
      ?>
      <a href="<?= htmlspecialchars($link['href']) ?>" class="nav-item <?= $active ?>">
        <img src="/Edu_Streak_Lock_in/public/assets/icon-box.png" alt="<?= htmlspecialchars($link['label']) ?>" class="nav-box-icon">
        <span class="nav-label"><?= htmlspecialchars($link['label']) ?></span>
      </a>
      <?php endforeach; ?>
    </nav>
  </aside>

  <!-- SIDEBAR ARROW -->
  <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle sidebar">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <!-- MAIN WRAPPER -->
  <div class="main-wrapper">

    <!-- TOPBAR -->
    <header class="topbar">
      <div class="topbar-items">
        <div class="topbar-item">
          <img src="/Edu_Streak_Lock_in/public/assets/icon-html.png" alt="html" class="html5-icon">
        </div>
        <div class="topbar-item">
          <img src="/Edu_Streak_Lock_in/public/assets/streak-black.png" alt="streak" class="streakblack-icon">
          <span class="streak-count"><?= $streak ?></span>
        </div>
        <div class="topbar-item">
          <img src="/Edu_Streak_Lock_in/public/assets/coin.png" alt="gems" class="coin-icon">
          <span class="coin-count"><?= $gems ?></span>
        </div>
        <div class="topbar-item">
          <img src="/Edu_Streak_Lock_in/public/assets/icon-heart.png" alt="hearts" class="heartfull-icon">
          <span class="streak-count"><?= $hearts ?>/5</span>
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <div class="content-area">

      <!-- LEFT: stage map -->
      <div class="left-panel">

        <div class="level-header">
          <a href="/Edu_Streak_Lock_in/public/learn" class="back-link">← Back</a>
          <div class="level-lang-info">
            <img src="<?= htmlspecialchars($language['icon_url'] ?? '') ?>"
                 alt="<?= htmlspecialchars($language['name']) ?>"
                 class="level-lang-icon">
            <h1 class="page-title"><?= htmlspecialchars($language['name']) ?></h1>
          </div>
        </div>
        <hr class="divider"/>

        <!-- Scrollable stage map -->
        <div class="stage-scroll">
          <div class="stage-container">

            <?php
            $nodeSize = 90;
            $half     = $nodeSize / 2;
            $lastIdx  = min(count($tracks) - 1, count($positions) - 1);
            $svgH     = $lastIdx >= 0 ? ($positions[$lastIdx]['top'] + $nodeSize + 60) : 200;
            ?>

            <!-- SVG dashed lines between nodes -->
            <svg class="stage-lines" width="550" height="<?= $svgH ?>" xmlns="http://www.w3.org/2000/svg">
              <?php foreach ($tracks as $i => $track):
                if ($i === 0) continue;
                $prev = $positions[$i - 1] ?? null;
                $curr = $positions[$i]     ?? null;
                if (!$prev || !$curr) continue;
                $x1 = $prev['left'] + $half;
                $y1 = $prev['top']  + $half;
                $x2 = $curr['left'] + $half;
                $y2 = $curr['top']  + $half;
                $color = ($unlocked[$track['id']] ?? false) ? '#12e6c8' : '#3d4c58';
              ?>
              <line
                x1="<?= $x1 ?>" y1="<?= $y1 ?>"
                x2="<?= $x2 ?>" y2="<?= $y2 ?>"
                stroke="<?= $color ?>"
                stroke-width="4"
                stroke-dasharray="10 8"
                stroke-linecap="round"
              />
              <?php endforeach; ?>
            </svg>

            <!-- Nodes -->
            <?php foreach ($tracks as $i => $track):
              $pos    = $positions[$i] ?? ['top' => $i * 150, 'left' => 150];
              $isOpen = $unlocked[$track['id']] ?? false;
              $pct    = (float)$track['completion_pct'];
              $done   = $pct >= 100;
              $style  = "top:{$pos['top']}px; left:{$pos['left']}px;";
            ?>

            <?php if ($isOpen): ?>
              <a href="/Edu_Streak_Lock_in/public/students/<?= htmlspecialchars($language['slug']) ?>/tracks/<?= htmlspecialchars($track['id']) ?>"
                 class="stage-node open <?= $done ? 'done' : '' ?>"
                 style="<?= $style ?>">
                <span class="stage-icon"><?= $done ? '★' : '☆' ?></span>
                <span class="stage-label"><?= htmlspecialchars($track['title']) ?></span>
                <?php if ($pct > 0 && !$done): ?>
                  <div class="stage-progress-wrap">
                    <div class="stage-progress-bar" style="width:<?= (int)$pct ?>%"></div>
                  </div>
                <?php endif; ?>
              </a>
            <?php else: ?>
              <div class="stage-node locked" style="<?= $style ?>">
                <span class="stage-icon">🔒</span>
                <span class="stage-label"><?= htmlspecialchars($track['title']) ?></span>
              </div>
            <?php endif; ?>

            <?php endforeach; ?>

          </div>
        </div>

      </div>

      <!-- RIGHT PANEL -->
      <aside class="right-panel">

        <div class="quest-card">
          <h3 class="quest-title">Your Quest for today!</h3>
          <div class="quest-body">
            <div class="quest-lock">
              <img src="/Edu_Streak_Lock_in/public/assets/Vector.png" alt="Lock">
            </div>
            <p class="quest-desc">Complete 2 of this question</p>
          </div>
        </div>

        <div class="quest-card extra-quest-card">
          <div class="extra-quest-header">
            <h3 class="quest-title">Extra Quest</h3>
            <a href="#" class="lihat-semua">Lihat semua</a>
          </div>
          <div class="quest-body extra-body">
            <div class="bolt-icon">
              <img src="/Edu_Streak_Lock_in/public/assets/petir.png" alt="petir">
            </div>
            <div class="extra-info">
              <p class="extra-desc">Keep up with your streak 20 times</p>
              <div class="progress-row">
                <div class="progress-bar-wrap">
                  <div class="progress-bar" style="width: <?= min(100, ($streak/20)*100) ?>%"></div>
                </div>
                <span class="progress-label"><?= $streak ?>/20</span>
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

        <?php if (!empty($_SESSION['user']['google_id'])): ?>
        <div class="quest-card profile-card">
          <img src="<?= htmlspecialchars($user['avatar_url'] ?? '') ?>" alt="avatar" class="profile-avatar">
          <p class="profile-text"><?= htmlspecialchars($user['name'] ?? $user['username']) ?></p>
          <a href="/Edu_Streak_Lock_in/public/students/profile" class="btn btn-blue">View Profile</a>
        </div>
        <?php else: ?>
        <div class="quest-card profile-card">
          <p class="profile-text">Make your profile to keep your streak!</p>
          <a href="/Edu_Streak_Lock_in/public/students/profile" class="btn btn-green">Make profile</a>
          <a href="/Edu_Streak_Lock_in/public/auth/google" class="btn btn-blue">Sign in with Google</a>
        </div>
        <?php endif; ?>

      </aside>

    </div>
  </div>
</div>

<script src="/Edu_Streak_Lock_in/public/js/students.js"></script>
</body>
</html>