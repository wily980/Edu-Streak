// ── Left sidebar toggle ───────────────────────────────────────────────────
const sidebar  = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

// ── Right panel toggle (levels page only) ─────────────────────────────────
const arrow2     = document.getElementById('sidebar2Arrow');
const rightPanel = document.getElementById('rightPanel');

if (arrow2 && rightPanel) {
  arrow2.addEventListener('click', () => {
    rightPanel.classList.toggle('shrink');
    arrow2.classList.toggle('shrink');
  });
}
