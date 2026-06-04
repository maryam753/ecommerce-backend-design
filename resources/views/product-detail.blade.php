@extends('app')

@section('title', $product->name)

@push('styles')
<link rel="stylesheet" href="{{ secure_asset('css/productdetail.css') }}">
@endpush

@section('content')

<div class="pd-container">

    <div class="product-card">

        <div class="gallery">
            <div class="gallery-main">
                <img src="{{ secure_asset('storage/' . $product->image) }}" alt="{{ $product->name }}" id="mainImgEl">
            </div>

            @if($product->images && $product->images->count())
            <div class="gallery-thumbs">
                @foreach($product->images as $img)
                <div class="thumb" onclick="setThumb(this, '{{ secure_asset('storage/' . $img->path) }}')">
                    <img src="{{ secure_asset('storage/' . $img->path) }}" alt="{{ $product->name }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="product-info">
            <div class="in-stock">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
            </div>

            <h1 class="product-title">{{ $product->name }}</h1>

            <div class="product-meta">
                @if($product->rating)
                <div class="stars">
                    @for($s = 1; $s <= 5; $s++)
                        <svg width="14" height="14"
                             fill="{{ $s <= round($product->rating) ? 'currentColor' : 'none' }}"
                             stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                    <span class="rating-num">{{ $product->rating }}</span>
                </div>
                @endif

                @if($product->reviews_count)
                    <span class="meta-sep">|</span>
                    <span>{{ $product->reviews_count }} reviews</span>
                @endif

                @if($product->sold_count)
                    <span class="meta-sep">|</span>
                    <span>{{ $product->sold_count }} sold</span>
                @endif
            </div>

            @if($product->priceTiers && $product->priceTiers->count())
            <div class="price-tiers">
                @foreach($product->priceTiers as $tier)
                <div class="price-tier {{ $loop->first ? 'active' : '' }}">
                    <span class="tier-price">${{ number_format($tier->price, 2) }}</span>
                    <span class="tier-label">
                        {{ $tier->min }}–{{ $tier->max ? $tier->max : '∞' }} pcs
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <div class="price-tiers">
                <div class="price-tier active">
                    <span class="tier-price">${{ number_format($product->price, 2) }}</span>
                </div>
            </div>
            @endif

            <div class="specs">
                @if($product->price_negotiable)
                <div class="spec-row">
                    <span class="spec-label">Price:</span>
                    <span class="spec-value">Negotiable</span>
                </div>
                @endif

                @if($product->type)
                <div class="spec-row">
                    <span class="spec-label">Type:</span>
                    <span class="spec-value">{{ $product->type }}</span>
                </div>
                @endif

                @if($product->material)
                <div class="spec-row">
                    <span class="spec-label">Material:</span>
                    <span class="spec-value">{{ $product->material }}</span>
                </div>
                @endif

                @if($product->design)
                <div class="spec-row">
                    <span class="spec-label">Design:</span>
                    <span class="spec-value">{{ $product->design }}</span>
                </div>
                @endif

                @if($product->customization)
                <div class="spec-row">
                    <span class="spec-label">Customization:</span>
                    <span class="spec-value">{{ $product->customization }}</span>
                </div>
                @endif

                @if($product->protection)
                <div class="spec-row">
                    <span class="spec-label">Protection:</span>
                    <span class="spec-value">{{ $product->protection }}</span>
                </div>
                @endif

                @if($product->warranty)
                <div class="spec-row">
                    <span class="spec-label">Warranty:</span>
                    <span class="spec-value">{{ $product->warranty }}</span>
                </div>
                @endif
            </div>

            <div class="product-buttons">
<button class="btn-cart" onclick="addToCart({{ $product->id }})">
    Add to Cart
</button>
<form action="{{ route('buy.now') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="btn-buy">
        Buy Now
    </button>
         </form>
        </div>
        </div>
        </div>

    <div class="tabs-section">
        <div class="tabs-card">
            <div class="tab-nav">
                <button class="tab-btn active" onclick="switchTab(this, 'description')">Description</button>
                <button class="tab-btn" onclick="switchTab(this, 'reviews')">Reviews</button>
                <button class="tab-btn" onclick="switchTab(this, 'shipping')">Shipping</button>
                <button class="tab-btn" onclick="switchTab(this, 'about-seller')">About Seller</button>
            </div>

            <div id="tab-description" class="tab-content active">

                @if($product->description)
                <p>{{ $product->description }}</p>
                @endif

                {{-- Spec Table --}}
                @if($product->model || $product->style || $product->certificate || $product->size || $product->memory)
                <table class="spec-table">
                    @if($product->model)
                    <tr><td>Model</td><td>{{ $product->model }}</td></tr>
                    @endif
                    @if($product->style)
                    <tr><td>Style</td><td>{{ $product->style }}</td></tr>
                    @endif
                    @if($product->certificate)
                    <tr><td>Certificate</td><td>{{ $product->certificate }}</td></tr>
                    @endif
                    @if($product->size)
                    <tr><td>Size</td><td>{{ $product->size }}</td></tr>
                    @endif
                    @if($product->memory)
                    <tr><td>Memory</td><td>{{ $product->memory }}</td></tr>
                    @endif
                </table>
                @endif

                @if($product->features && $product->features->count())
                <div class="feature-list">
                    @foreach($product->features as $feature)
                    <div class="feature-item">{{ $feature->name ?? $feature }}</div>
                    @endforeach
                </div>
                @endif

            </div>

            <div id="tab-reviews" class="tab-content">
                @if($product->reviews && $product->reviews->count())
                    @foreach($product->reviews as $review)
                    <div class="review-item">
                        <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                        <span class="review-rating">{{ $review->rating }}/5</span>
                        <p>{{ $review->comment }}</p>
                    </div>
                    @endforeach
                @else
                    <p>No reviews yet.</p>
                @endif
            </div>

            <div id="tab-shipping" class="tab-content">
                @if($product->shipping_info)
                    <p>{{ $product->shipping_info }}</p>
                @else
                    <p>Shipping information not available.</p>
                @endif
            </div>

            <div id="tab-about-seller" class="tab-content">
                @if($product->seller)
                    <p><strong>{{ $product->seller->name }}</strong></p>
                    <p>{{ $product->seller->description }}</p>
                @else
                    <p>Seller information not available.</p>
                @endif
            </div>
        </div>

@if(isset($youMayLike) && $youMayLike->count())
        <div class="you-may-like">
            <h4>You may like</h4>
            @foreach($youMayLike as $item)
            <a href="{{ route('product.detail', $item->id) }}" class="side-product">
                <div class="side-img">
                    <img src="{{ secure_asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                </div>
                <div class="side-info">
                    <div class="side-name">{{ $item->name }}</div>
                    <div class="side-price">${{ number_format($item->price, 2) }}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>


@if(isset($relatedProducts) && $relatedProducts->count())
    <div class="related-section">
        <div class="section-title">Related products</div>
        <div class="products-grid">
            @foreach($relatedProducts as $rp)
            <a href="{{ route('product.detail', $rp->id) }}" class="product-thumb-card">
                <div class="product-thumb-img">
                    <img src="{{ secure_asset('storage/' . $rp->image) }}" alt="{{ $rp->name }}">
                </div>
                <div class="product-thumb-info">
                    <div class="product-thumb-name">{{ $rp->name }}</div>
                    <div class="product-thumb-price">${{ number_format($rp->price, 2) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif


    <div class="promo-banner">
        <div class="promo-text">
            <h3>Super discount on more than 100 USD</h3>
            <p>Have you ever finally just write dummy info</p>
        </div>
        <a href="" class="btn-shop">Shop now</a>
    </div>

@include('profile.partials.login-modal')
@include('profile.partials.register-modal')

@endsection

@push('scripts')
<script src="{{ secure_asset('js/productdetail.js') }}"></script>
@endpush