<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Brand – B2B Ecommerce')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  @stack('styles')
</head>
<body>

  {{--  TOP HEADER --}}
  <header class="topbar">
    <div class="container inner">

      {{-- Brand logo --}}
      <a href="{{ url('/') }}" class="brand">
        <div class="brand-icon">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
        Brand
      </a>

      {{-- Search --}}
    <div class="search-wrap" style="position:relative;">
    <input type="text" id="searchInput" placeholder="Search products..." />
    <select name="category" id="categorySelect">
    <option value="">All category</option>

    @foreach($categories as $category)
        <option value="{{ $category->id }}">
            {{ $category->name }}
        </option>
    @endforeach
</select>
    <button class="search-btn">Search</button>
    {{-- RESULTS --}}
<div id="searchResults" class="search-results" ></div>
</div>

      {{-- Nav icons --}}
      <div class="nav-icons">
      <div class="nav-icon-item profile-dropdown-wrap" style="position:relative; cursor:pointer;">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        {{-- Show user name if logged in, else "Profile" --}}
        @auth
            {{ Auth::user()->name }}
        @else
            Profile
        @endauth

        {{-- Dropdown --}}
        @auth
        <div class="profile-dropdown">
            <div class="dropdown-user">
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
        @endauth
    </div>
        
        <div class="nav-icon-item">
          <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
           <a href="{{url('/my-orders')}}">Orders</a> 
        </div>
       <div class="nav-icon-item">
    <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h11a2 2 0 002-2v-1M7 13L5.4 5M16 19a1 1 0 100 2 1 1 0 000-2zM9 19a1 1 0 100 2 1 1 0 000-2z"/>
    </svg>
    <a href="{{ route('cart.index') }}">
        Cart
        <span id="cartCount">{{ $cartCount }}</span>
    </a>
</div>

    </div>
  </header>

  {{-- 
       SUB-NAVIGATION
   --}}
  <nav class="subnav">
    <div class="container inner">
      <div class="subnav-left">
         <div class="subnav-item allcat" id="allCategoryBtn">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          All category
        </div>
       <a href="{{ url('/') }}" class="subnav-item">Home</a>
       <a href="{{ url('/') }}#deals" class="subnav-item">Deals and Offers</a>
       <a href="{{ url('/') }}#recommended" class="subnav-item">Recommended Items</a>
       <a href="{{ url('/product') }}" class="subnav-item">Menu item</a>
       <a href="#footer" class="subnav-item">Help <span class="chevron">▾</span></a>
      </div>
      <div class="subnav-right">
        <select>
          <option>English, USD</option>
          <option>Arabic, AED</option>
        </select>
         <select>
          <option>Ship to <img src="Layout1/Image/flags/GB@2x.png" alt=""></option>
          <option>Ship to <img src="Layout1/Image/flags/CN@2x.png" alt=""></option>
        </select>
        <!-- <span>Ship to  <img src="Layout1/Image/flags/GB@2x.png" alt=""> ▾</span> -->
      </div>
    </div>
  </nav>

  {{-- 
       PAGE CONTENT
   --}}
  <main>
    @yield('content')
  </main>

  {{--  NEWSLETTER + FOOTER --}}
  <section class="newsletter-section">
    <div class="container">
      <h3>Subscribe on our newsletter</h3>
      <p>Get daily news on upcoming offers from many suppliers all over the world</p>
      <div class="newsletter-form">
        <input type="email" placeholder="✉ Email" />
        <button class="btn btn-primary">Subscribe</button>
      </div>
    </div>
  </section>

  <footer id="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="{{ url('/') }}" class="brand" style="margin-bottom:10px;">
            <div class="brand-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
            Brand
          </a>
          <p>Best information about the company goes here but now lorem ipsum is</p>
          <div class="footer-socials">
            <a href="#">f</a><a href="#">t</a><a href="#">in</a><a href="#">ig</a><a href="#">yt</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>About</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Find store</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Blogs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Partnership</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Find store</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Blogs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Information</h4>
          <ul>
            <li><a href="#">Help Center</a></li>
            <li><a href="#">Money Refund</a></li>
            <li><a href="#">Shipping</a></li>
            <li><a href="#">Contact us</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>For users</h4>
          <ul>
            <li><a href="#">Login</a></li>
            <li><a href="#">Register</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">My Orders</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Get app</h4>
          <div class="app-badges">
            <div class="app-badge">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
              App Store
            </div>
            <div class="app-badge">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3.18 23.76c.3.17.64.23.99.17l12.6-12.6-2.93-2.92-10.66 15.35zm15.34-14.2L16.5 7.55 3.59.31C3.25.13 2.87.08 2.54.2l12.52 12.52 3.46-3.16zm2.17 5.46c.42-.25.69-.7.69-1.2a1.35 1.35 0 00-.67-1.17l-2.8-1.6-3.17 3.17 3.16 3.16 2.79-2.36zM3.59 23.68l12.92-12.91L4 4.26c-.36.15-.62.48-.62.9v17.59c0 .44.28.79.21.93z"/></svg>
              Google Play
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2023 Ecommerce.</span>
        <span>🇺🇸 English</span>
      </div>
    </div>
  </footer>


 <script>
document.getElementById('allCategoryBtn').addEventListener('click', function () {
    window.location.href = "{{ route('products') }}";
});
        window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
   
    function openModal(modal){
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal(modal){
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}
const input = document.getElementById('searchInput');
const resultsBox = document.getElementById('searchResults');
const categorySelect = document.getElementById('categorySelect');

let timer = null;

function searchProducts() {

    const q = input.value.trim();
    const category = categorySelect.value;

    if (q.length < 2) {
        resultsBox.innerHTML = '';
        resultsBox.style.display = 'none';
        return;
    }

    fetch(`/search?q=${encodeURIComponent(q)}&category=${category}`)
        .then(res => res.json())
        .then(data => {

            resultsBox.innerHTML = '';

            if (!data.length) {
                resultsBox.innerHTML = `<div class="search-item">No results found</div>`;
                resultsBox.style.display = 'block';
                return;
            }

            data.forEach(product => {
                resultsBox.innerHTML += `
                    <div class="search-item" onclick="goToProduct(${product.id})">
                        ${product.name}
                        <small>(${product.category?.name ?? ''})</small>
                    </div>
                `;
            });

            resultsBox.style.display = 'block';
        })
        .catch(err => console.log(err));
}

input.addEventListener('keyup', function () {
    clearTimeout(timer);
    timer = setTimeout(searchProducts, 300);
});

document.querySelector('.search-btn').addEventListener('click', searchProducts);

document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-wrap')) {
        resultsBox.style.display = 'none';
    }
});

/* redirect */
function goToProduct(id) {
    window.location.href = `/product-detail/${id}`;
}
</script>
 @stack('scripts')
</body>
</html>