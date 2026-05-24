<?php
// app/views/Shop/shop.php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }
$user        = $_SESSION['user'];
$hearts      = (int)($user['hearts']  ?? 5);
$gems        = (int)($user['gems']    ?? 0);
$streak      = (int)($user['streak']  ?? 0);
$maxHearts   = 5;
$heartsFull  = $hearts >= $maxHearts;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shop - EduStreak</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/shop.css"/>
</head>
<body>
<div class="app-root">

  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>/assets/Logoutama.png" alt="EduStreak" class="logo-img">
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
    <svg viewBox="0 0 24 24" id="arrowSvg" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="topbar-items">
        <div class="topbar-item html5">
          <img src="<?= BASE_URL ?>/assets/icon-html.png" alt="html" class="html5-icon">
        </div>
        <div class="topbar-item streak">
          <img src="<?= BASE_URL ?>/assets/streak-black.png" alt="streak" class="streakblack-icon">
          <span class="streak-count" id="streakCount"><?= $streak ?></span>
        </div>
        <div class="topbar-item coins">
          <img src="<?= BASE_URL ?>/assets/coin.png" alt="gems" class="coin-icon">
          <span class="coin-count" id="gemCount"><?= $gems ?></span>
        </div>
        <div class="topbar-item hearts">
          <img src="<?= BASE_URL ?>/assets/icon-heart.png" alt="hearts" class="heartfull-icon">
          <span class="heart-count" id="heartCount"><?= $hearts ?>/<?= $maxHearts ?></span>
        </div>
      </div>
    </header>

    <div class="content-area">
      <div class="left-panel">
        <h1 class="page-title">Shop</h1>
        <hr class="divider"/>

        <?php if (empty($items)): ?>
          <p class="empty-msg">No items available right now. Check back soon!</p>
        <?php else: ?>
          <?php foreach ($items as $item):
            $isFull    = ($item['type'] === 'heart' && $heartsFull);
            $canAfford = ($gems >= $item['cost']);
          ?>
          <div class="shop-card" data-item-id="<?= htmlspecialchars($item['id']) ?>">
            <div class="shop-item-icon">
              <?php
              $icon = match($item['type'] ?? '') {
                  'heart'  => BASE_URL . '/assets/heart1.png',
                  'streak' => BASE_URL . '/assets/streak-black.png',
                  default  => BASE_URL . '/assets/coin.png',
              };
              ?>
              <img src="<?= $icon ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            </div>
            <div class="shop-item-info">
              <h2 class="shop-item-title"><?= htmlspecialchars($item['name']) ?></h2>
              <p class="shop-item-desc"><?= htmlspecialchars($item['description'] ?? '') ?></p>
            </div>
            <div class="shop-item-action">
              <?php if ($isFull): ?>
                <div class="full-badge">FULL</div>
              <?php else: ?>
                <button
                  class="btn btn-buy <?= $canAfford ? 'btn-green' : 'btn-disabled' ?>"
                  data-item-id="<?= htmlspecialchars($item['id']) ?>"
                  data-item-name="<?= htmlspecialchars($item['name']) ?>"
                  data-cost="<?= (int)$item['cost'] ?>"
                  <?= $canAfford ? '' : 'disabled' ?>
                >
                  <img src="<?= BASE_URL ?>/assets/coin.png" alt="gem" class="btn-gem-icon">
                  <?= (int)$item['cost'] ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
          <hr class="divider"/>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <aside class="right-panel">
        <div class="quest-card">
          <h3 class="quest-title">Your Quest for today!</h3>
          <div class="quest-body">
            <div class="quest-lock">
              <img src="<?= BASE_URL ?>/assets/Vector.png" alt="Lock">
            </div>
            <p class="quest-desc">Complete 2 of this question</p>
          </div>
        </div>

        <div class="quest-card extra-quest-card">
          <div class="extra-quest-header">
            <h3 class="quest-title">Extra Quest</h3>
            <a href="<?= BASE_URL ?>/quest" class="lihat-semua">Lihat semua</a>
          </div>
          <div class="quest-body extra-body">
            <div class="bolt-icon">
              <img src="<?= BASE_URL ?>/assets/petir.png" alt="petir">
            </div>
            <div class="extra-info">
              <p class="extra-desc">Keep up with your streak 20 times</p>
              <div class="progress-row">
                <div class="progress-bar-wrap">
                  <div class="progress-bar" style="width: <?= min(100, ($streak / 20) * 100) ?>%"></div>
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
          <a href="<?= BASE_URL ?>/profile" class="btn btn-blue">View Profile</a>
        </div>
        <?php else: ?>
        <div class="quest-card profile-card">
          <p class="profile-text">Make your profile to keep your streak!</p>
          <a href="<?= BASE_URL ?>/profile" class="btn btn-green">Make profile</a>
          <a href="<?= BASE_URL ?>/auth/google" class="btn btn-blue">Sign in with Google</a>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>
<script src="<?= BASE_URL ?>/js/shop.js"></script>
</body>
</html>