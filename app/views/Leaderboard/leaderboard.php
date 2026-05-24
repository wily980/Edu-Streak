<?php
// app/views/Leaderboard/leaderboard.php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }
$rankColors = ['#FFD700', '#C0C0C0', '#CD7F32'];
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

  <button class="sidebar-arrow" id="sidebarArrow" aria-label="Toggle sidebar">
    <svg viewBox="0 0 24 24" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <div class="main-wrapper">
    <div class="center-panel">
      <div class="medal-group">
        <span class="sparkle sparkle-1">✦</span>
        <span class="sparkle sparkle-2">✦</span>
        <span class="sparkle sparkle-3">✦</span>
        <img src="<?= BASE_URL ?>/assets/image 10.png" alt="Medals" class="medal-combined">
      </div>

      <h1 class="score-title">Look at your score</h1>
      <p class="score-subtitle">for this month and<br/>compare it with the other</p>

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
            <?php if ($isMe): ?><span class="lb-you">You</span><?php endif; ?>
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

      <div class="my-rank-bar">
        <span>Your rank this month</span>
        <span class="my-rank-num">#<?= $myRank ?></span>
      </div>
    </div>

    <aside class="right-panel">
      <div class="info-card">
        <p class="info-label">How Does this page works?</p>
        <h2 class="info-title">Learn, Compete, and use your exp</h2>
        <p class="info-desc">Reach the highest score as possible this month and compare it with your previous month</p>
        <img src="<?= BASE_URL ?>/assets/robot 1.png" alt="Robot" class="robot-img">
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