<?php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }
$u        = $user;
$name     = htmlspecialchars($u['name'] ?? $u['username']);
$username = htmlspecialchars($u['username'] ?? '');
$bio      = htmlspecialchars($u['bio'] ?? '');
$avatar   = htmlspecialchars($u['avatar_url'] ?? '');
$banner   = htmlspecialchars($u['banner_url'] ?? '');
$streak   = (int)($u['streak'] ?? 0);
$hearts   = (int)($u['hearts'] ?? 5);
$gems     = (int)($u['gems'] ?? 0);
$joined   = !empty($u['created_at']) ? date('F Y', strtotime($u['created_at'])) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $name ?> - EduStreak</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/profile.css"/>
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
    <div class="left-panel">
      <div class="profile-card">
        <div class="banner" style="<?= $banner ? 'background-image: url(' . $banner . ')' : '' ?>">
          <button class="edit-btn" id="editBtn" title="Edit profile">✏</button>
        </div>
        <div class="avatar-row">
          <div class="avatar-wrap">
            <?php if ($avatar): ?>
              <img src="<?= $avatar ?>" alt="<?= $name ?>" class="avatar-img">
            <?php else: ?>
              <div class="avatar-placeholder"><?= strtoupper(substr($name, 0, 1)) ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="profile-info">
          <h2 class="profile-name"><?= $name ?></h2>
          <p class="profile-username"><?= $username ?></p>
          <?php if ($joined): ?><p class="profile-joined">Joined at <?= $joined ?></p><?php endif; ?>
          <?php if ($bio): ?><p class="profile-bio"><?= $bio ?></p><?php endif; ?>
          <div class="follow-row">
            <span class="follow-item">Follower <strong>0</strong></span>
            <span class="follow-item">Following <strong>0</strong></span>
          </div>
          <div class="lang-badges">
            <?php foreach ($languages as $lang): ?>
              <img src="<?= BASE_URL . $lang['icon_url'] ?>" alt="<?= htmlspecialchars($lang['name']) ?>" class="lang-badge" title="<?= htmlspecialchars($lang['name']) ?>">
            <?php endforeach; ?>
          </div>
        </div>
        <div class="stats-section">
          <h3 class="stats-title">Statistik</h3>
          <div class="stats-grid">
            <div class="stat-card">
              <span class="stat-value"><?= number_format($totalXp) ?></span>
              <span class="stat-label">Total XP</span>
            </div>
            <div class="stat-card">
              <span class="stat-value"><?= $streak ?></span>
              <span class="stat-label">Streak</span>
            </div>
            <div class="stat-card">
              <span class="stat-value"><?= $lessonsDone ?></span>
              <span class="stat-label">Lessons Done</span>
            </div>
            <div class="stat-card">
              <span class="stat-value"><?= count($languages) ?></span>
              <span class="stat-label">Languages</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <aside class="right-panel">
      <div class="topbar">
        <div class="topbar-items">
          <div class="topbar-item">
            <img src="<?= BASE_URL ?>/assets/icon-html.png" alt="html" class="html5-icon">
          </div>
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
      </div>

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
                <div class="progress-bar" style="width: <?= min(100, ($streak/20)*100) ?>%"></div>
              </div>
              <span class="progress-label"><?= $streak ?>/20</span>
            </div>
          </div>
        </div>
      </div>
    </aside>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-header">
      <h3>Edit Profile</h3>
      <button class="modal-close" id="modalClose">×</button>
    </div>
    <form action="<?= BASE_URL ?>/profile/edit" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <label class="form-label">Banner</label>
        <input type="file" name="banner" accept="image/*" class="form-file">
        <label class="form-label">Avatar</label>
        <input type="file" name="avatar" accept="image/*" class="form-file">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="<?= $username ?>" class="form-input" placeholder="Username">
        <label class="form-label">Bio</label>
        <textarea name="bio" class="form-textarea" placeholder="Tell something about yourself..."><?= $bio ?></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" id="modalCancel">Cancel</button>
        <button type="submit" class="btn-save">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
const sidebar  = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');
arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});
const editBtn      = document.getElementById('editBtn');
const modalOverlay = document.getElementById('modalOverlay');
const modalClose   = document.getElementById('modalClose');
const modalCancel  = document.getElementById('modalCancel');
editBtn.addEventListener('click', () => modalOverlay.classList.add('open'));
modalClose.addEventListener('click', () => modalOverlay.classList.remove('open'));
modalCancel.addEventListener('click', () => modalOverlay.classList.remove('open'));
modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) modalOverlay.classList.remove('open'); });
</script>
</body>
</html>