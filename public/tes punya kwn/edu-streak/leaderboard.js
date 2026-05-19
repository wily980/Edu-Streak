const sidebar = document.getElementById('sidebar');
const arrowBtn = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

// ===== PAGE TRANSITION =====
document.querySelectorAll('a.nav-item').forEach(link => {
  link.addEventListener('click', function (e) {
    const href = this.getAttribute('href');

    // Abaikan kalau buka tab baru atau bukan link internal
    if (!href || href.startsWith('http') || href.startsWith('#')) return;

    e.preventDefault();

    // Jalankan animasi keluar
    document.body.classList.add('page-exit');

    // Tunggu animasi selesai, baru pindah
    setTimeout(() => {
      window.location.href = href;
    }, 250); // Harus sama dengan durasi fadeSlideOut
  });
});