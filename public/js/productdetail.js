  // Thumbnail switcher
    function setThumb(el, src) {
        document.getElementById('mainImgEl').src = src;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    // Tabs
    function switchTab(btn, tabId) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    // Price tier highlight
    document.querySelectorAll('.price-tier').forEach(tier => {
        tier.addEventListener('click', function () {
            document.querySelectorAll('.price-tier').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
function addToCart(productId) {

    if (!window.isLoggedIn) {
        document.getElementById('loginModal').style.display = 'flex';
        return;
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) return;

        const cartCount = document.getElementById('cartCount');

        if (cartCount) {
            cartCount.textContent = data.count; // 🔥 LIVE UPDATE
        }

        showToast('Added to cart', 'success');
    })
    .catch(err => {
        console.log(err);
        showToast('Error adding to cart', 'error');
    });
}
function showToast(msg, type = 'success') {
    let toast = document.createElement('div');

    toast.style.position = 'fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.padding = '12px 18px';
    toast.style.background = type === 'success' ? '#00c853' : '#d50000';
    toast.style.color = '#fff';
    toast.style.borderRadius = '8px';
    toast.style.zIndex = '99999';
    toast.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
    toast.style.fontSize = '14px';

    toast.innerText = msg;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}
document.addEventListener('DOMContentLoaded', function () {
    const loginModal = document.getElementById('loginModal');

    document.getElementById('closeLogin')?.addEventListener('click', () => {
        loginModal.style.setProperty('display', 'none', 'important');
    });

    window.addEventListener('click', (e) => {
        if (e.target === loginModal) {
            loginModal.style.setProperty('display', 'none', 'important');
        }
    });
});