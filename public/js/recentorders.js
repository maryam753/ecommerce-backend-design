    function toggleDetail(index, btn) {
        const panel = document.getElementById('detail-' + index);
        const isOpen = panel.classList.toggle('open');
        btn.innerHTML = isOpen
            ? `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg> Hide Details`
            : `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> View Details`;
    }

    function setFilter(status, btn) {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.order-card').forEach(card => {
            card.style.display = (status === 'all' || card.dataset.status === status) ? '' : 'none';
        });
    }

    function filterOrders() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.order-card').forEach(card => {
            card.style.display = card.innerText.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    function sortOrders(method) {
        const list = document.getElementById('ordersList');
        const cards = [...list.querySelectorAll('.order-card')];
        cards.sort((a, b) => {
            if (method === 'highest') return parseFloat(b.dataset.total) - parseFloat(a.dataset.total);
            if (method === 'lowest')  return parseFloat(a.dataset.total) - parseFloat(b.dataset.total);
            return method === 'oldest' ? 1 : -1;
        });
        cards.forEach(c => list.appendChild(c));
    }