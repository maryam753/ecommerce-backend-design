@extends('app')
@section('title', 'My Orders')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush
@section('content')

<div class="page-wrapper">

    <h1>My Recent Orders</h1>
    @forelse ($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <strong>#{{ $order->id }}</strong><br>
                    <small>{{ $order->created_at->format('M d, Y') }}</small>
                </div>
                <span class="status">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="order-items">
                @foreach($order->items as $item)
                    <div class="item">
                        <span>{{ $item->product->name ?? 'Product' }}</span>
                        <span>Qty: {{ $item->quantity ?? $item->qty ?? 1 }}</span>
                        <span>${{ $item->price }}</span>
                    </div>
                @endforeach
            </div>

            <div class="order-total">
                <strong>Total:</strong> ${{ $order->total }}
            </div>

        </div>

    @empty
        <p>No orders found.</p>
    @endforelse

</div>

@endsection