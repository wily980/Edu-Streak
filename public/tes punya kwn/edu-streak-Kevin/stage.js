const sidebar = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

const rightPanel = document.querySelector('.right-panel');
const arrow2 = document.getElementById('sidebar2Arrow');

arrow2.addEventListener('click', () => {
  rightPanel.classList.toggle('shrink');
  arrow2.classList.toggle('shrink');
});