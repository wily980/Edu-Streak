<?php
if (empty($user)) { header('Location: ' . BASE_URL . '/'); exit; }

$hearts = (int)($user['hearts'] ?? 5);
$gems   = (int)($user['gems']   ?? 0);
$streak = (int)($user['streak'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Code History - EduStreak</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/students.css"/>
  <style>
    .history-header { padding: 24px 0 8px; }
    .history-header h1 { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
    .history-header p  { color: #7a8a99; margin: 4px 0 0; font-size: 0.9rem; }

    .history-list { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }

    .history-item {
      background: #1a2332;
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      border: 1px solid #243040;
      transition: border-color 0.2s;
    }
    .history-item:hover { border-color: #12e6c8; }

    .lang-icon { width: 36px; height: 36px; object-fit: contain; flex-shrink: 0; }

    .history-info { flex: 1; min-width: 0; }
    .history-info .lesson-title { font-weight: 700; color: #fff; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .history-info .lesson-meta  { font-size: 0.78rem; color: #7a8a99; margin-top: 3px; }

    .history-badges { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

    .badge {
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
    }
    .badge-completed { background: #0d3d2e; color: #12e6c8; }
    .badge-progress  { background: #2d2a0d; color: #f0c040; }
    .badge-locked    { background: #2a2a2a; color: #666; }

    .history-score { text-align: right; flex-shrink: 0; }
    .history-score .score-val { font-size: 1.1rem; font-weight: 800; color: #12e6c8; }
    .history-score .score-label { font-size: 0.7rem; color: #7a8a99; }

    .empty-state { text-align: center; padding: 60px 20px; color: #7a8a99; }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: 12px; }
    .empty-state p { font-size: 0.95rem; }
  </style>
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

  <button class="sidebar-arrow" id="sidebarArrow">
    <svg viewBox="0 0 24 24" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="topbar-items">
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/icon-html.png" alt="html" class="html5-icon">
        </div>
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/streak-black.png" alt="streak" class="streakblack-icon">
          <span class="streak-count"><?= $streak ?></span>
        </div>
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/coin.png" alt="gems" class="coin-icon">
          <span class="coin-count"><?= $gems ?></span>
        </div>
        <div class="topbar-item">
          <img src="<?= BASE_URL ?>/assets/icon-heart.png" alt="hearts" class="heartfull-icon">
          <span class="streak-count"><?= $hearts ?>/5</span>
        </div>
      </div>
    </header>

    <div class="content-area">
      <div class="left-panel">
        <div class="history-header">
          <h1>Code History</h1>
          <p>All your lessons and progress in one place</p>
        </div>

        <div class="history-list">
          <?php if (empty($history)): ?>
            <div class="empty-state">
              <div class="empty-icon">📭</div>
              <p>No lessons yet! Go pick a language and start learning.</p>
              <a href="<?= BASE_URL ?>/learn" class="btn btn-blue" style="margin-top:16px; display:inline-block;">Start Learning</a>
            </div>
          <?php else: ?>
            <?php foreach ($history as $item): ?>
            <div class="history-item">
              <?php if (!empty($item['language_icon'])): ?>
                <img src="<?= BASE_URL . htmlspecialchars($item['language_icon']) ?>" alt="<?= htmlspecialchars($item['language_name']) ?>" class="lang-icon">
              <?php endif; ?>
              <div class="history-info">
                <div class="lesson-title"><?= htmlspecialchars($item['lesson_title']) ?></div>
                <div class="lesson-meta">
                  <?= htmlspecialchars($item['language_name']) ?> &bull;
                  <?= htmlspecialchars($item['track_title']) ?> &bull;
                  <?= ucfirst($item['type']) ?>
                  <?php if ($item['completed_at']): ?>
                    &bull; <?= date('d M Y', strtotime($item['completed_at'])) ?>
                  <?php endif; ?>
                </div>
              </div>
              <div class="history-badges">
                <?php
                  $badgeClass = match($item['status']) {
                    'completed'   => 'badge-completed',
                    'in_progress' => 'badge-progress',
                    default       => 'badge-locked',
                  };
                ?>
                <span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $item['status'])) ?></span>
              </div>
              <div class="history-score">
                <div class="score-val"><?= $item['score'] ?></div>
                <div class="score-label">score</div>
              </div>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= BASE_URL ?>/js/students.js"></script>
</body>
</html>