@extends('app')
@section('title', 'Brand  B2B Marketplace')

@push('styles')
<link rel="stylesheet" href="{{ secure_secure_asset('css/home.css') }}" />
@endpush

@section('content')
{{-- HERO  --}}
<section class="hero-section">
  <div class="container">
    <div class="hero-grid">
    <ul class="sidebar-cats">
    @foreach($categories as $category)
        <li>
             <a href="javascript:void(0)"
               onclick="showCategoryProducts({{ $category->id }})">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
    </ul>

   <div id="heroArea">
    <div class="hero-banner" id="defaultBanner">
        <div style="position:relative;z-index:2;">
          <span class="label">Latest trending</span>
          <h1>Electronic<br>items</h1>

          <a href="#" class="btn btn-outline"
             style="border-color:rgba(255,255,255,.6);color:#fff;">
            Learn more
          </a>
        </div>
        <div class="hero-img"
             style="--hero-bg: url('{{ secure_asset('Image/backgrounds/Banner-board-800x420 2.png') }}');">
        </div>
        <div class="hero-dots" style="z-index:2;">
          <span class="active"></span>
          <span></span>
          <span></span>
        </div>
    </div>
    <div id="categoryProducts" class="category-products-grid" style="display:none;">
    </div>
</div>

      <div class="auth-sidebar">
        <div class="auth-card">
         @auth
    <h3>Hi, {{ Auth::user()->name }}!</h3>
    <p style="font-size:12px;color:#6b7280;">{{ Auth::user()->email }}</p>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-primary btn-block mb-8" 
              style="border:none;cursor:pointer;">
        Logout
      </button>
    </form>
  @else
    <h3>Hi, user<br>let's get started</h3>
    <p></p>
    <a href="javascript:void(0)" id="openRegister" class="btn btn-primary btn-block mb-8">
      Join now
    </a>
    <a href="javascript:void(0)" id="openLogin" class="btn btn-outline btn-block">
      Log in
    </a>
  @endauth
        </div>
        <div class="promo-card">
          <h4>
            <span class="promo-icon"
                  style="--icon-bg: url('{{ secure_asset('Image/backgrounds/Group 969.png') }}');"></span>
            Get US $10 off
          </h4>
          <p>with a new supplier</p>
        </div>
        <div class="supplier-card">
          <span class="supplier-icon"
                style="--icon-bg: url('{{ secure_asset('Image/backgrounds/Group 982.png') }}');"></span>
          <p>Shopping with best Discount Prices</p>
          <a href="#deals" class="btn btn-sm"
             style="background:rgba(255,255,255,.2);color:#fff;width:100%;">Shop now</a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- DEALS & OFFERS --}}
@if($deals->count())
<section class="deals-section" id="deals" style="margin-bottom:20px;">
  <div class="container">
    <div class="deals-header">
      <div>
        <h2 class="section-title" style="margin-bottom:2px;">Deals and offers</h2>
      </div>
      <div class="countdown">
        <div class="countdown-item">
          <span class="num" id="cd-days">04</span>
          <span class="lbl">Days</span>
        </div>
        <div class="countdown-item">
          <span class="num" id="cd-hrs">13</span>
          <span class="lbl">Hour</span>
        </div>
        <div class="countdown-item">
          <span class="num" id="cd-min">34</span>
          <span class="lbl">Min</span>
        </div>
        <div class="countdown-item">
          <span class="num" id="cd-sec">56</span>
          <span class="lbl">Sec</span>
        </div>
      </div>
    </div>

    <div class="deals-grid">
      @foreach($deals as $product)
     <a href="{{ route('product.detail', $product->id) }}" class="deal-card-link">
    <div class="deal-card">
  <div class="img-wrap">
    <img src="{{ secure_asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
  </div>
  <div class="name">{{ $product->name }}</div>

  @if($product->price > 0 && $product->discount_price > 0)
    <div style="margin-top:6px;">
      <span style="font-size:13px; color:#94a3b8; text-decoration:line-through;">
        ${{ number_format($product->price, 2) }}
      </span>
      <span style="font-size:14px; font-weight:700; color:#e11d48; margin-left:6px;">
        ${{ number_format($product->discount_price, 2) }}
      </span>
    </div>
    <div class="price-off" style="margin-top:4px;">
      -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
    </div>
  @else
    <div style="font-size:14px; font-weight:700; color:#1e293b; margin-top:6px;">
      ${{ number_format($product->price, 2) }}
    </div>
  @endif
    </div>
</a>
      @endforeach
    </div>
  </div>
</section>
@endif


<div class="cat-section">
  <div class="cat-section-label">
    <div class="cat-label-img"
         style="--cat-img: url('{{ secure_asset('Image/backgrounds/image 98.png') }}');"></div>
    <h3>Home and decor</h3>
    <a href="{{url('/product')}}" class="btn btn-outline btn-sm mt-8">Source now</a>
  </div>
  <div class="cat-products">
    @forelse($homeDecor as $p)
   <a href="{{ route('product.detail', $p->id) }}">
    <div class="cat-product">
            <div class="img-wrap">
        <img src="{{ secure_asset('storage/' . $p->image) }}" alt="{{ $p->name }}"
             onerror="this.src='https://via.placeholder.com/60x50/F0F4FF/2563EB?text=🏠'" />
      </div>
      <div class="name">{{ $p->name }}</div>
      <div class="price">PKR {{ number_format($p->price, 2) }}</div>
  </div>
</a>
    @empty
    <p style="color:#94a3b8;font-size:13px;padding:10px;">No products found.</p>
    @endforelse
  </div>
</div>


<div class="cat-section">
  <div class="cat-section-label">
    <div class="cat-label-img"
         style="--cat-img: url('{{ secure_asset('Image/backgrounds/image 106.png') }}');"></div>
    <h3> Computer and Tech</h3>
    <a href="{{url('/product')}}" class="btn btn-outline btn-sm mt-8">Source now</a>
  </div>
  <div class="cat-products">
    @forelse($computer as $p)
<a href="{{ route('product.detail', $p->id) }}">
    <div class="cat-product">
            <div class="img-wrap">
        <img src="{{ secure_asset('storage/' . $p->image) }}" alt="{{ $p->name }}"
             onerror="this.src='https://via.placeholder.com/60x50/F0F9FF/0284C7?text=📱'" />
      </div>
      <div class="name">{{ $p->name }}</div>
      <div class="price">PKR {{ number_format($p->price, 2) }}</div>
    </div>
</a>
    @empty
    <p style="color:#94a3b8;font-size:13px;padding:10px;">No products found.</p>
    @endforelse
  </div>
</div>

  {{--  RECOMMENDED ITEMS --}}
<h2 class="section-title" id="recommended">Recommended items</h2>
<div class="items-grid mb-24">
    @forelse($recommended as $product)
    <a href="{{ route('product.detail', $product->id) }}"
       style="text-decoration:none;color:inherit;">
        <div class="item-card">
            <div class="img-wrap">
                <img src="{{ secure_asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}">
            </div>
            @if($product->discount_price > 0)
                <div class="price">
                    PKR {{ number_format($product->discount_price, 2) }}
                </div>
            @else
                <div class="price">
                    PKR {{ number_format($product->price, 2) }}
                </div>
            @endif
            <div class="name">
                {{ $product->name }}
            </div>
        </div>
    </a>
    @empty
    <p>No recommended products found.</p>
    @endforelse
</div>

  {{--  EXTRA SERVICES --}}
  <h2 class="section-title">Our extra services</h2>
  <div class="services-grid mb-24">
    @php
      $services = [
        ['Image/background/Mask group (1).png', 'Source from Industry Hubs',               '🔍'],
        ['Image/background/Mask group.png',     'Customize Your Products',                 '📐'],
        ['Image/backgrounds/image 107.png',     'Fast, reliable shipping by ocean or air', '✈'],
        ['Image/backgrounds/image 107.png',     'Product monitoring and inspection',       '🌐'],
      ];
    @endphp
    @foreach($services as $s)
    <div class="service-card">
      <div style="background:linear-gradient(135deg,#1e40af,#0284c7);width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:10px;padding:20px;text-align:center;">
        <div class="service-icon" style="font-size:18px;">{{ $s[2] }}</div>
        <p style="color:#fff;font-size:13px;font-weight:600;">{{ $s[1] }}</p>
      </div>
    </div>
    @endforeach
  </div>

  {{--    SUPPLIERS BY REGION --}}
  <h2 class="section-title">Suppliers by region</h2>
  <div class="region-grid mb-24">
    @php
      $regions = [
        ['Layout1/Image/flags/AE@2x.png', 'Arabic Emirates', 'shopname.ae'],
        ['Layout1/Image/flags/icon.png',  'Australia',       'shopname.au'],
        ['Layout1/Image/flags/US@2x.png', 'United States',   'shopname.us'],
        ['Layout1/Image/flags/RU@2x.png', 'Russia',          'shopname.ru'],
        ['Layout1/Image/flags/IT@2x.png', 'Italy',           'shopname.it'],
        ['Layout1/Image/flags/DK@2x.png', 'Denmark',         'shopname.dk'],
        ['Layout1/Image/flags/FR@2x.png', 'France',          'shopname.fr'],
        ['Layout1/Image/flags/CN@2x.png', 'China',           'shopname.cn'],
        ['Layout1/Image/flags/GB@2x.png', 'Great Britain',   'shopname.co.uk'],
      ];
    @endphp
    @foreach($regions as $r)
    <div class="region-item">
      <img src="{{ asset($r[0]) }}"
           alt="{{ $r[1] }}"
           onerror="this.src='https://via.placeholder.com/30x20?text=🏳';" />
      <div>
        <div class="country">{{ $r[1] }}</div>
        <div class="url">{{ $r[2] }}</div>
      </div>
    </div>
    @endforeach
  </div>
  
@include('profile.partials.login-modal')
@include('profile.partials.register-modal')

@endsection

@push('scripts')
<script src="{{ secure_secure_asset('js/home.js') }}"></script>

@endpush