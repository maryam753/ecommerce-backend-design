@extends('app')
@section('title', 'Product Listing')
@push('styles')
<link rel="stylesheet" href="{{ secure_asset('css/product-listing.css') }}">
@endpush
@section('content')


<div class="shop-layout">
    <aside class="sidebar">
        <form method="GET" action="{{ url('/product') }}" id="filterForm">
            <div class="sidebar-links">
                <div class="sidebar-title">Categories</div>
                @foreach($categories as $cat)
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="checkbox"
                               name="category[]"
                               value="{{ $cat->id }}"
                               {{ in_array($cat->id, request('category', [])) ? 'checked' : '' }}>
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>

            <div style="padding: 16px 18px; border-bottom: 1px solid var(--gray-100);">
                <div class="sidebar-title">Condition</div>
                <label><input type="checkbox" name="condition[]" value="new"> New</label>
                <label><input type="checkbox" name="condition[]" value="refurbished"> Refurbished</label>
                <label><input type="checkbox" name="condition[]" value="used"> Used</label>
            </div>

            <div style="padding: 16px 18px; border-bottom: 1px solid var(--gray-100);">
                <div class="sidebar-title">Ratings</div>
                <label><input type="checkbox" name="rating[]" value="5"> ★★★★★&nbsp; 5 Star</label>
                <label><input type="checkbox" name="rating[]" value="4"> ★★★★☆&nbsp; 4+ Star</label>
                <label><input type="checkbox" name="rating[]" value="3"> ★★★☆☆&nbsp; 3+ Star</label>
            </div>

            <button type="submit" class="clear-filters">Search Product</button>

        </form>

    </aside>


    <main class="main-content">
        <div class="content-header">
            <div class="result-count">
                {{ $products->count() }} items in
                <strong>
                    {{ $categories->whereIn('id', request('category', []))->pluck('name')->join(', ') ?: 'All Products' }}
                </strong>
            </div>

            <label class="verified-check">
                <input type="checkbox" name="verified"
                       form="filterForm"
                       value="1"
                       {{ request('verified') ? 'checked' : '' }}>
                Verified only
            </label>

            <select class="sort-select" name="sort" form="filterForm">
                <option value="">Featured</option>
                <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="newest"     {{ request('sort') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                <option value="rating"     {{ request('sort') == 'rating'     ? 'selected' : '' }}>Best Rated</option>
            </select>

            <div class="view-toggle">
                <button class="view-btn active" id="gridBtn" onclick="switchView('grid')">
                    <i class="fa fa-grip"></i> Grid
                </button>
                <button class="view-btn" id="listBtn" onclick="switchView('list')">
                    <i class="fa fa-list"></i> List
                </button>
            </div>

        </div>

        <div class="active-filters">

            @if(request('category'))
                @foreach($categories->whereIn('id', request('category')) as $cat)
                    <a class="filter-tag"
                       href="{{ request()->fullUrlWithQuery(['category' => array_values(array_diff(request('category'), [$cat->id]))]) }}">
                        {{ $cat->name }} <i class="fa fa-times"></i>
                    </a>
                @endforeach
            @endif

            @if(request('condition'))
                @foreach(request('condition') as $cond)
                    <a class="filter-tag"
                       href="{{ request()->fullUrlWithQuery(['condition' => array_values(array_diff(request('condition'), [$cond]))]) }}">
                        {{ ucfirst($cond) }} <i class="fa fa-times"></i>
                    </a>
                @endforeach
            @endif

            @if(request('rating'))
                @foreach(request('rating') as $rate)
                    <a class="filter-tag"
                       href="{{ request()->fullUrlWithQuery(['rating' => array_values(array_diff(request('rating'), [$rate]))]) }}">
                        {{ $rate }}+ Star <i class="fa fa-times"></i>
                    </a>
                @endforeach
            @endif

            @if(request('verified'))
                <a class="filter-tag"
                   href="{{ request()->fullUrlWithQuery(['verified' => null]) }}">
                    Verified <i class="fa fa-times"></i>
                </a>
            @endif

            @if(request()->hasAny(['category','condition','rating','verified','sort']))
                <a class="clear-filters" href="{{ url('/product') }}">
                    Clear all filters
                </a>
            @endif

        </div>

     <!-- grid view -->
<div class="products-grid" id="gridView">

@forelse($products as $product)

<a href="{{ route('product.detail', $product->id) }}"
   style="text-decoration:none; color:inherit;">

    <div class="product-card grid-card">

        <button class="wishlist-btn">
            <i class="fa-regular fa-heart"></i>
        </button>

        <div class="card-image">
            <img src="{{ secure_asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="card-body">
            <div class="price-block">
                <span class="price-now">${{ $product->price }}</span>
                @if($product->discount_price)
                    <span class="price-old">${{ $product->discount_price }}</span>
                @endif
            </div>

            <div class="product-name">{{ $product->name }}</div>
        </div>

    </div>

</a>

@empty
    <p>No products found</p>
@endforelse

</div>

        <!--  LIST VIEW -->
<div class="products-list hidden" id="listView">

@forelse($products as $product)

<a href="{{ route('product.detail', $product->id) }}"
   style="text-decoration:none; color:inherit;">

    <div class="product-card list-card">

        <div class="card-image">
            <img src="{{ secure_asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="card-body">

            <span class="product-badge">
                {{ $product->category->name ?? '' }}
            </span>
            <div class="product-name">{{ $product->name }}</div>
            <div class="price-now">${{ $product->price }}</div>
        </div>
    </div>
</a>
@empty
    <p>No products found</p>
@endforelse
</div>
    </main>
</div>
@endsection
@push('scripts')
<script src="{{ secure_asset('js/productlisting.js') }}"></script>
@endpush