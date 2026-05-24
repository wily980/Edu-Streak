<?php
if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }
$totalQ    = count($questions);
$langSlug  = $track['lang_slug'] ?? 'html';
$langName  = $track['lang_name'] ?? '';
$langIcon  = $track['lang_icon'] ?? '';
$trackName = $track['title'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($trackName) ?> - EduStreak</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/lesson.css"/>
</head>
<body>
<div class="app-root">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>/assets/Logoutama.png" alt="EduStreak" class="logo-img">
    </div>
    <nav class="nav-items">
      <?php
      $navLinks = [
        ['label' => 'Home', 'href' => BASE_URL . '/students'],
        ['label' => 'Code',        'href' => BASE_URL . '/'],
        ['label' => 'Leaderboard', 'href' => BASE_URL . '/leaderboard'],
        ['label' => 'Quest',       'href' => BASE_URL . '/quest'],
        ['label' => 'Shop',        'href' => BASE_URL . '/students/shop'],
        ['label' => 'Profile',     'href' => BASE_URL . '/profile'],
      ];
      $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      foreach ($navLinks as $link):
        $slug   = str_replace(BASE_URL, '', $link['href']);
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
  <button class="sidebar-arrow" id="sidebarArrow">
    <svg viewBox="0 0 24 24" class="arrow-svg">
      <polyline points="15 18 9 12 15 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <!-- MAIN WRAPPER -->
  <div class="main-wrapper">

    <!-- LEFT: Lesson area -->
    <div class="lesson-panel">

      <?php if (empty($questions)): ?>
        <div class="empty-state">
          <div class="empty-icon">📭</div>
          <h2>No questions here yet!</h2>
          <p>Check back soon or pick another track.</p>
          <a href="<?= BASE_URL ?>/level?lang=<?= $langSlug ?>" class="btn-back-link">← Back to levels</a>
        </div>

      <?php else: ?>

        <!-- Progress bar -->
        <div class="lesson-topbar">
          <a href="<?= BASE_URL ?>/level?lang=<?= $langSlug ?>" class="close-btn" title="Exit">✕</a>
          <div class="progress-track">
            <div class="progress-fill" id="progressFill" style="width: 0%"></div>
          </div>
          <div class="hearts-display">
            <?php for ($h = 0; $h < $hearts; $h++): ?>
              <span class="heart">❤️</span>
            <?php endfor; ?>
            <?php for ($h = $hearts; $h < 5; $h++): ?>
              <span class="heart empty">🖤</span>
            <?php endfor; ?>
          </div>
        </div>

        <!-- Track info -->
        <div class="track-info">
          <img src="<?= BASE_URL . $langIcon ?>" alt="<?= $langName ?>" class="track-lang-icon">
          <div>
            <div class="track-name"><?= htmlspecialchars($trackName) ?></div>
            <div class="track-sub"><?= htmlspecialchars($langName) ?> · <?= $totalQ ?> questions</div>
          </div>
        </div>

        <!-- Question slides -->
        <form id="lessonForm" action="<?= BASE_URL ?>/lesson/submit" method="POST">
          <input type="hidden" name="lesson_id"  value="<?= htmlspecialchars($currentLesson['id']) ?>">
          <input type="hidden" name="track_id"   value="<?= htmlspecialchars($track['id']) ?>">
          <input type="hidden" name="lang_slug"  value="<?= htmlspecialchars($langSlug) ?>">
          <input type="hidden" name="score"      id="scoreInput" value="0">
          <input type="hidden" name="total"      value="<?= $totalQ ?>">

          <?php foreach ($questions as $qi => $q): ?>
          <div class="question-slide <?= $qi === 0 ? 'active' : '' ?>"
               data-index="<?= $qi ?>"
               data-correct="<?php
                 foreach ($q['options'] as $opt) {
                   if ($opt['is_correct']) { echo htmlspecialchars($opt['id']); break; }
                 }
               ?>">

            <div class="question-counter">Question <?= $qi + 1 ?> of <?= $totalQ ?></div>

            <div class="question-box">
              <div class="question-label">Pick the correct answer</div>
              <h2 class="question-text"><?= htmlspecialchars($q['question_text']) ?></h2>
              <?php if (!empty($q['code_snippet'])): ?>
              <pre class="code-snippet"><code><?= htmlspecialchars($q['code_snippet']) ?></code></pre>
              <?php endif; ?>
            </div>

            <div class="options-grid">
              <?php foreach ($q['options'] as $opt): ?>
              <button type="button" class="option-btn" data-id="<?= htmlspecialchars($opt['id']) ?>">
                <?= htmlspecialchars($opt['text']) ?>
              </button>
              <?php endforeach; ?>
            </div>

            <div class="feedback-bar" id="feedback-<?= $qi ?>">
              <div class="feedback-content">
                <span class="feedback-icon"></span>
                <span class="feedback-text"></span>
              </div>
              <button type="button" class="btn-next" id="next-<?= $qi ?>">
                <?= $qi < $totalQ - 1 ? 'Continue →' : 'Finish! 🎉' ?>
              </button>
            </div>

          </div>
          <?php endforeach; ?>

        </form>

      <?php endif; ?>

    </div>

    <!-- RIGHT: Quest panel -->
    <aside class="right-panel">
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

      <div class="quest-card">
        <h3 class="quest-title">Your Quest for today!</h3>
        <div class="quest-body">
          <div class="quest-lock"><img src="<?= BASE_URL ?>/assets/Vector.png" alt="Lock"></div>
          <p class="quest-desc">Complete 2 of this question</p>
        </div>
      </div>

      <div class="quest-card">
        <div class="extra-quest-header">
          <h3 class="quest-title">Extra Quest</h3>
          <a href="<?= BASE_URL ?>/quest" class="lihat-semua">Lihat semua</a>
        </div>
        <div class="quest-body extra-body">
          <div class="bolt-icon"><img src="<?= BASE_URL ?>/assets/petir.png" alt="petir"></div>
          <div class="extra-info">
            <p class="extra-desc">Keep up your streak 20 times</p>
            <div class="progress-row">
              <div class="progress-bar-wrap">
                <div class="progress-bar" style="width:<?= min(100,($streak/20)*100) ?>%"></div>
              </div>
              <span class="progress-label"><?= $streak ?>/20</span>
            </div>
          </div>
        </div>
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

const slides       = document.querySelectorAll('.question-slide');
const progressFill = document.getElementById('progressFill');
const scoreInput   = document.getElementById('scoreInput');
const totalQ       = slides.length;
let currentIdx     = 0;
let score          = 0;

function updateProgress() {
  progressFill.style.width = (currentIdx / totalQ) * 100 + '%';
}
function showSlide(idx) {
  slides.forEach(s => s.classList.remove('active'));
  if (slides[idx]) slides[idx].classList.add('active');
  updateProgress();
}

slides.forEach((slide, idx) => {
  const correctId = slide.dataset.correct;
  const optBtns   = slide.querySelectorAll('.option-btn');
  const feedback  = document.getElementById('feedback-' + idx);
  const nextBtn   = document.getElementById('next-' + idx);
  let answered    = false;

  optBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (answered) return;
      answered = true;
      const isCorrect = btn.dataset.id === correctId;
      optBtns.forEach(b => {
        b.classList.remove('selected','correct','wrong');
        if (b.dataset.id === correctId) b.classList.add('correct');
      });
      if (!isCorrect) btn.classList.add('wrong');
      btn.classList.add('selected');
      const icon = feedback.querySelector('.feedback-icon');
      const text = feedback.querySelector('.feedback-text');
      if (isCorrect) {
        score++;
        feedback.classList.add('show','correct');
        icon.textContent = '✓';
        text.textContent = 'Correct! Great job!';
      } else {
        feedback.classList.add('show','wrong');
        icon.textContent = '✕';
        text.textContent = 'Wrong! Keep going!';
      }
      scoreInput.value = score;
    });
  });

  nextBtn.addEventListener('click', () => {
    if (idx < totalQ - 1) {
      currentIdx++;
      showSlide(currentIdx);
    } else {
      progressFill.style.width = '100%';
      setTimeout(() => { document.getElementById('lessonForm').submit(); }, 400);
    }
  });
});

updateProgress();
</script>
</body>
</html>