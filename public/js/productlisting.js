   function switchView(view) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const gridBtn  = document.getElementById('gridBtn');
        const listBtn  = document.getElementById('listBtn');

        if (view === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            localStorage.setItem('shopView', 'grid');
        } else {
            listView.classList.remove('hidden');
            gridView.classList.add('hidden');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            localStorage.setItem('shopView', 'list');
        }
    }

    // Restore saved preference on load
    document.addEventListener('DOMContentLoaded', function () {
        const saved = localStorage.getItem('shopView');
        if (saved === 'list') switchView('list');
    });

    // Wishlist toggle
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.className = 'fa-solid fa-heart';
                icon.style.color = 'var(--red)';
            } else {
                icon.className = 'fa-regular fa-heart';
                icon.style.color = '';
            }
        });
    });

    // Filter tag remove
    document.querySelectorAll('.filter-tag').forEach(tag => {
        tag.addEventListener('click', function () {
            this.style.opacity = '0';
            this.style.transform = 'scale(0.8)';
            setTimeout(() => this.remove(), 200);
        });
    });