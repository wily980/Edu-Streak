// public/js/quest.js

// ── Sidebar toggle ──────────────────────────────────────────────
const sidebar  = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

// ── Smooth page transitions (same as your other pages) ─────────
document.querySelectorAll('a.nav-item').forEach(link => {
  link.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (!href || href.startsWith('http') || href.startsWith('#')) return;
    e.preventDefault();
    document.body.classList.add('page-exit');
    setTimeout(() => { window.location.href = href; }, 250);
  });
});

// ── Daily quest reset countdown ─────────────────────────────────
function updateResetTimer() {
  const timerEl = document.getElementById('resetTimer');
  if (!timerEl) return;

  const now      = new Date();
  const midnight = new Date();
  midnight.setHours(24, 0, 0, 0);

  const diffMs  = midnight - now;
  const hours   = Math.floor(diffMs / (1000 * 60 * 60));
  const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

  timerEl.textContent = `${hours}h ${minutes}m`;
}

updateResetTimer();
setInterval(updateResetTimer, 60 * 1000);

// ── Animate progress bars on load ───────────────────────────────
window.addEventListener('load', () => {
  document.querySelectorAll('.quest-progress-fill').forEach(bar => {
    const target = bar.style.width;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = target; }, 100);
  });
});