// ── Sidebar toggle ────────────────────────────────────────────────────────
const sidebar    = document.getElementById('sidebar');
const arrowBtn   = document.getElementById('sidebarArrow');

arrowBtn.addEventListener('click', () => {
  sidebar.classList.toggle('expanded');
  arrowBtn.classList.toggle('expanded');
});

// ── Toast helper ──────────────────────────────────────────────────────────
const toastEl = document.getElementById('toast');
let toastTimer;

function showToast(message, type = 'success') {
  clearTimeout(toastTimer);
  toastEl.textContent = message;
  toastEl.className   = `toast ${type} show`;
  toastTimer = setTimeout(() => {
    toastEl.className = 'toast';
  }, 3000);
}

// ── Buy buttons ───────────────────────────────────────────────────────────
document.querySelectorAll('.btn-buy').forEach(btn => {
  btn.addEventListener('click', async () => {
    if (btn.disabled) return;

    const itemId   = btn.dataset.itemId;
    const itemName = btn.dataset.itemName;
    const cost     = parseInt(btn.dataset.cost, 10);

    // Optimistic disable to prevent double-click
    btn.disabled = true;

    try {
      const formData = new FormData();
      formData.append('item_id', itemId);

      const res  = await fetch('/shop/buy', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.success) {
        showToast(`✅ ${data.message}`, 'success');

        // Update topbar counts live
        const gemEl   = document.getElementById('gemCount');
        const heartEl = document.getElementById('heartCount');
        if (gemEl)   gemEl.textContent   = data.gems;
        if (heartEl) heartEl.textContent = `${data.hearts}/5`;

        // If hearts are now full, swap buy button for FULL badge
        if (data.hearts >= 5) {
          const card = btn.closest('.shop-card');
          const actionDiv = card?.querySelector('.shop-item-action');
          if (actionDiv) {
            actionDiv.innerHTML = '<div class="full-badge">FULL</div>';
          }
        } else {
          btn.disabled = false;
        }

        // Disable any heart-refill buttons if now full
        if (data.hearts >= 5) {
          document.querySelectorAll('.btn-buy[data-item-type="heart"]').forEach(b => {
            b.closest('.shop-item-action').innerHTML = '<div class="full-badge">FULL</div>';
          });
        }

        // Re-enable or grey out buttons based on new gem count
        document.querySelectorAll('.btn-buy').forEach(b => {
          const bCost = parseInt(b.dataset.cost, 10);
          if (data.gems < bCost) {
            b.disabled = true;
            b.classList.replace('btn-green', 'btn-disabled');
          }
        });

      } else {
        showToast(`❌ ${data.message}`, 'error');
        btn.disabled = false;
      }

    } catch (err) {
      console.error('Buy error:', err);
      showToast('❌ Something went wrong. Try again.', 'error');
      btn.disabled = false;
    }
  });
});
