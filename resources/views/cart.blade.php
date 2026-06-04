@extends('app')

@section('title', 'My Cart - Brand')

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/cart.css') }}" />
@endpush

@section('content')

<div class="page-wrapper">
<h1 class="page-title">My cart ({{ $cartItems->count() }})</h1>
<div class="cart-layout">

    <div>
        <div class="cart-card">
            @forelse($cartItems as $item)
            <div class="cart-item">
                <div class="item-img">
                    <img src="{{ secure_asset('storage/' . $item->product->image) }}"
                         alt="{{ $item->product->name }}">
                </div>

                <div class="item-info">
                    <div class="item-name">
                        {{ $item->product->name }}
                    </div>
                    <div class="item-meta">
                        Price: PKR {{ number_format($item->product->price,2) }}
                    </div>
                    <div class="item-actions">

                        {{-- REMOVE ITEM --}}
                        <form action="{{ route('cart.remove',$item->id) }}"
                              method="POST"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn-link btn-remove">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>

                <div class="item-right">
                    <span class="item-price">
                        PKR {{ number_format($item->product->price * $item->quantity,2) }}
                    </span>

                    <form action="{{ route('cart.qty',$item->id) }}"
                          method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="qty"
                                class="qty-select"
                                onchange="this.form.submit()">

                            @for($q=1;$q<=20;$q++)
                                <option value="{{ $q }}"
                                    {{ $item->quantity == $q ? 'selected' : '' }}>
                                    Qty: {{ $q }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>
            @empty

            <div style="padding:40px;text-align:center;">
                <h3>Your cart is empty</h3>
                <p>
                    Add some products to your cart.
                </p>
                <a href="{{ url('/') }}"
                   class="btn-back">
                    Continue Shopping
                </a>
            </div>

            @endforelse

            @if($cartItems->count())
            <div class="cart-footer">
                <a href="{{ url('/') }}"
                   class="btn-back">
                    Back to shop
                </a>

                <form action="{{ route('cart.clear') }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn-remove-all">
                        Remove all
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <div>
        <div class="summary-card">
            <div class="summary-row subtotal">
                <span>Subtotal:</span>
                <span>
                    PKR {{ number_format($subtotal,2) }}
                </span>
            </div>

            <div class="summary-row tax">
                <span>Tax:</span>
                <span>
                    PKR {{ number_format($tax,2) }}
                </span>
            </div>

            <div class="summary-total-row">

                <span class="total-label">
                    Total:
                </span>

                <span class="total-amount">
                    PKR {{ number_format($total,2) }}
                </span>

            </div>
<form action="{{ route('checkout.cart') }}" method="GET">
    <button type="submit" class="btn-checkout">
        Checkout
    </button>
</form>

        </div>
    </div>
</div>

    <div class="promo-banner">
        <div class="promo-text">
            <h3>Super discount on more than 100 USD</h3>
            <p>Have you ever finally just write dummy info</p>
        </div>
        <button class="btn-shop">Shop now</button>
    </div>
</div>

@endsection