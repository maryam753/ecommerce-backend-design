<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

</head>
<body>

<!-- TOP BAR -->
<header class="topbar">
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-icon">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
        Brand
      </a>

    <a href="/cart" class="cart-btn">
        🛒 Cart
    </a>
</header>

<!-- MAIN -->
<div class="checkout-container">

    <!-- LEFT FORM -->
    <form action="/place-order" method="POST" class="checkout-form">
        @csrf

        <h2>Checkout Details</h2>

        <!-- SHIPPING -->
        <div class="section">
            <h3>Shipping Details</h3>

            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>

            <input type="text" name="country" placeholder="Country" required>
            <input type="text" name="city" placeholder="City" required>

            <textarea name="address" placeholder="Full Address" required></textarea>
        </div>

        <!-- BILLING -->
        <div class="section">
            <h3>Billing Address (optional)</h3>
            <textarea name="billing_address" placeholder="Billing Address"></textarea>
        </div>

        <!-- SHIPPING METHOD -->
        <div class="section">
            <h3>Shipping Method</h3>

            <label><input type="radio" name="shipping_method" value="standard" checked> Standard (Free)</label><br>
            <label><input type="radio" name="shipping_method" value="express"> Express ($10)</label>
        </div>

        <!-- PAYMENT -->
        <div class="section">
            <h3>Payment Method</h3>

            <label>
                <input type="radio" name="payment_method" value="cod" checked>
                Cash on Delivery (COD)
            </label>
        </div>

        <button type="submit" class="place-order-btn">
            Place Order
        </button>

    </form>

 <!-- RIGHT SUMMARY -->
<div class="summary">
    <h3>Order Summary</h3>

    @foreach($cartItems as $item)

        <div class="summary-item">
            @if(isset($item->product))
                {{ $item->product->name }} (x{{ $item->quantity }})
            @else
                {{ $item->name }} (x{{ $item->qty }})
            @endif
        </div>

    @endforeach

    <hr>

    <div class="total">
        <strong>Total:</strong>
        <strong>PKR {{ $total }}</strong>
    </div>
</div>
@if(session('success'))
    <div class="success-alert" id="successAlert">
        {{ session('success') }}
    </div>
@endif

<script>
    setTimeout(() => {
        let alertBox = document.getElementById('successAlert');
        if (alertBox) {
            alertBox.style.opacity = '0';
            alertBox.style.transform = 'translateY(-10px)';
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000); // 3 seconds
</script>
</body>
</html>