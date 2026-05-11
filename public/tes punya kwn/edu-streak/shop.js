const sidebar = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});