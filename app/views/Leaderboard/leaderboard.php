<?php
// app/views/Leaderboard/leaderboard.php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }

$rankColors = ['#FFD700', '#C0C0C0', '#CD7F32'];
$rankEmoji  = ['🥇', '🥈', '🥉'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Leaderboard - EduStreak</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/leaderboard.css"/>
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
      $navLinks = [
        ['label' => 'Home',     'href' => BASE_URL . '/students'],
        ['label' => 'Progress', 'href' => BASE_URL . '/students/progress'],
        ['label' => 'Score',    'href' => BASE_URL . '/leaderboard'],
        ['label' => 'Quest',    'href' => BASE_URL . '/students/quest'],
        ['label' => 'Shop',     'href' => BASE_URL . '/students/shop'],
        ['label' => 'Profile',  'href' => BASE_URL . '/students/profile'],
      ];
      $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      foreach ($navLinks as $link):
        $slug = str_replace(BASE_URL, '', $link['href']);
        $active = str_starts_with($currentPath, $slug) ? 'active' : '';
      ?>
      <a href="<?= $link['href'] ?>" class="nav-item <?= $active ?>">
        <img src="<?= BASE_URL ?>/assets/icon-box.png" alt="<?= $link['label'] ?>" class="nav-box-icon">
        <span class="nav-label"><?= $link['label'] ?></span>
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

    <!-- CENTER PANEL -->
    <div class="center-panel">

      <!-- Medal Group -->
      <div class="medal-group">
        <span class="sparkle sparkle-1">✦</span>
        <span class="sparkle sparkle-2">✦</span>
        <span class="sparkle sparkle-3">✦</span>
        <img src="<?= BASE_URL ?>/assets/leaderboard-icon.png" alt="Medals" class="medal-combined">
      </div>

      <h1 class="score-title">Look at your score</h1>
      <p class="score-subtitle">for this month and<br/>compare it with the other</p>

      <!-- Leaderboard -->
      <div class="leaderboard">
        <?php foreach ($topUsers as $i => $u):
          $isMe   = $u['id'] === $_SESSION['user']['id'];
          $name   = htmlspecialchars($u['name'] ?? $u['username']);
          $avatar = htmlspecialchars($u['avatar_url'] ?? '');
          $xp     = number_format($u['total_xp']);
          $color  = $rankColors[$i] ?? '#3bb8f5';
        ?>

        <div class="lb-row <?= $isMe ? 'lb-me' : '' ?>">
          <div class="lb-dot" style="background: <?= $color ?>"></div>
          <?php if ($avatar): ?>
            <img class="lb-avatar" src="<?= $avatar ?>" alt="<?= $name ?>">
          <?php else: ?>
            <div class="lb-avatar lb-avatar-placeholder"></div>
          <?php endif; ?>
          <div class="lb-name">
            <?= $name ?>
            <?php if ($isMe): ?>
              <span class="lb-you">You</span>
            <?php endif; ?>
          </div>
          <div class="lb-score"><?= $xp ?> XP</div>
        </div>

        <?php if ($i < count($topUsers) - 1): ?>
          <hr class="lb-divider">
        <?php endif; ?>

        <?php endforeach; ?>

        <?php if (empty($topUsers)): ?>
          <p style="color:#a0aabb;text-align:center;padding:20px">No scores yet. Start learning!</p>
        <?php endif; ?>
      </div>

      <!-- Your rank -->
      <div class="my-rank-bar">
        <span>Your rank this month</span>
        <span class="my-rank-num">#<?= $myRank ?></span>
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
        <img src="<?= BASE_URL ?>/assets/robot-image.png" alt="Robot" class="robot-img">
      </div>
    </aside>

  </div>
</div>

<script>
const sidebar  = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

document.querySelectorAll('a.nav-item').forEach(link => {
  link.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    if (!href || href.startsWith('http') || href.startsWith('#')) return;
    e.preventDefault();
    document.body.classList.add('page-exit');
    setTimeout(() => { window.location.href = href; }, 250);
  });
});
</script>

</body>
</html>
