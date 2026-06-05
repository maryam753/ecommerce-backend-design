document.addEventListener('DOMContentLoaded', function () {

    (function () {
        function pad(n) { return n < 10 ? '0' + n : n; }

        let total = 4 * 86400 + 13 * 3600 + 34 * 60 + 56;

        function tick() {
            if (total <= 0) return;

            total--;

            const d = Math.floor(total / 86400);
            const h = Math.floor((total % 86400) / 3600);
            const m = Math.floor((total % 3600) / 60);
            const s = total % 60;

            const set = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.textContent = pad(val);
            };

            set('cd-days', d);
            set('cd-hrs', h);
            set('cd-min', m);
            set('cd-sec', s);
        }

        setInterval(tick, 1000);
    })();


    
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');

  function openModal(modal) {
    modal.style.display = 'flex';          
    document.body.style.overflow = 'hidden';
}

    function closeModal(modal) {
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    const openLogin = document.getElementById('openLogin');
    const openRegister = document.getElementById('openRegister');
    const closeLogin = document.getElementById('closeLogin');
    const closeRegister = document.getElementById('closeRegister');
    const switchToRegister = document.getElementById('switchToRegister');
    const switchToLogin = document.getElementById('switchToLogin');

    if (openLogin) openLogin.onclick = () => openModal(loginModal);
    if (openRegister) openRegister.onclick = () => openModal(registerModal);
    if (closeLogin) closeLogin.onclick = () => closeModal(loginModal);
    if (closeRegister) closeRegister.onclick = () => closeModal(registerModal);

    if (switchToRegister) {
        switchToRegister.onclick = () => {
            closeModal(loginModal);
            openModal(registerModal);
        };
    }

    if (switchToLogin) {
        switchToLogin.onclick = () => {
            closeModal(registerModal);
            openModal(loginModal);
        };
    }

    window.onclick = function (e) {
        if (e.target === loginModal) closeModal(loginModal);
        if (e.target === registerModal) closeModal(registerModal);
    };

    window.showCategoryProducts = function (categoryId) {

        fetch(`/category/${categoryId}/products`)
            .then(res => res.json())
            .then(products => {

                const banner = document.getElementById('defaultBanner');
                const container = document.getElementById('categoryProducts');

                if (banner) banner.style.display = 'none';
                if (container) container.style.display = 'grid';

                if (!container) return;

                if (!products || products.length === 0) {
                    container.innerHTML = `
                        <div style="grid-column:1/-1;text-align:center;padding:40px;">
                            No products found
                        </div>
                    `;
                    return;
                }

                let html = '';

                products.forEach(product => {
                    html += `
                        <div class="category-product-card">
                            <a href="/product-detail/${product.id}">
                               <img src="${product.image && product.image.startsWith('http') ? product.image : '/storage/' + product.image}"
     onerror="this.src='https://via.placeholder.com/150'">

                                <h4>${product.name}</h4>
                                <p>Rs. ${product.price}</p>
                            </a>

                            <div class="product-actions">
                                <button class="btn btn-primary"
                                    onclick="buyNow(${product.id})">
                                    Buy Now
                                </button>

                                <button class="btn btn-outline"
                                    onclick="addToCart(${product.id})">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            });
    };


window.addToCart = function (productId) {

    if (!window.isLoggedIn) {
        openModal(loginModal);
        return;
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(res => res.json())
    .then(data => {

        showToast(data.message || "Added to cart!");

        if (data.cartCount !== undefined) {
            const cartCountEl = document.getElementById('cartCount');
            if (cartCountEl) {
                cartCountEl.innerText = data.cartCount;
            }
        }

    })
    .catch(() => {
        showToast("Something went wrong ");
    });
};
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
    window.buyNow = function (productId) {

        if (!window.isLoggedIn) {
            openModal(loginModal);
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/buy-now';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]').content;

        const product = document.createElement('input');
        product.type = 'hidden';
        product.name = 'product_id';
        product.value = productId;

        form.appendChild(csrf);
        form.appendChild(product);

        document.body.appendChild(form);
        form.submit();
    };

});
function submitLogin() {
    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    fetch(window.loginRoute, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(res => {
        if (res.ok || res.status === 422) return res.json();
        // Non-JSON redirect means login succeeded
        window.location.href = '/';
        return null;
    })
    .then(data => {
        if (!data) return;
        if (data.errors) {
            alert(Object.values(data.errors).flat().join('\n'));
        } else {
            window.location.href = '/';
        }
    })
    .catch(() => {
        window.location.href = '/';
    });
}

function submitRegister() {
    const form = document.getElementById('registerForm');
    const formData = new FormData(form);

    fetch(window.registerRoute, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(res => {
        if (res.ok || res.status === 422) return res.json();
        window.location.href = '/';
        return null;
    })
    .then(data => {
        if (!data) return;
        if (data.errors) {
            alert(Object.values(data.errors).flat().join('\n'));
        } else {
            window.location.href = '/';
        }
    })
    .catch(() => {
        window.location.href = '/';
    });
}