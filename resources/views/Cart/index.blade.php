@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Shopping Cart</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            <strong>Success:</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ session('error') }}
            @if(session('trace'))
                <pre>{{ session('trace') }}</pre>
            @endif
        </div>
    @endif

    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
        <table class="table">
            <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th><th>Action</th></tr>
            
            @php
                $cartTotal = 0;
            @endphp

            @foreach(session('cart', []) as $id => $details)
                @php
                    $subtotal = $details['product']->price * $details['quantity'];
                    $cartTotal += $subtotal;
                @endphp
                <tr>
                    <td>{{ $details['product']->title }}</td>
                    <td><input type="number" name="quantities[{{ $id }}]" value="{{ $details['quantity'] }}"></td>
                    <td>${{ number_format($details['product']->price, 2) }}</td>
                    <td>${{ number_format($subtotal, 2) }}</td>
                    <td>
                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
            @endforeach

            <!-- Display Cart Total -->
            <tr>
                <td colspan="3"><strong>Total:</strong></td>
                <td><strong>${{ number_format($cartTotal, 2) }}</strong></td>
                <td></td>
            </tr>
        </table>

        <button type="submit" class="btn btn-primary">Update Cart</button>
        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
    </form>
</div>
@endsection
