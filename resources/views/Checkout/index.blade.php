@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Checkout</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Order Summary</h5>
                    </div>
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
                    <div class="card-body">
                        <ul class="list-group">
                            @php $total = 0; @endphp
                            @foreach(session('cart', []) as $id => $item)
                                @php 
                                    $product = $item['product']; 
                                    $total += $product->price * $item['quantity'];
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $product->title }}</h6>
                                        <small>Price: ${{ $product->price }} x {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="badge bg-secondary">${{ $product->price * $item['quantity'] }}</span>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center">Total: ${{ $total }}</h4>
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile No</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Shipping Address</label>
                                <textarea name="address" id="address" class="form-control" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay With Paypal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            Your cart is empty. <a href="{{ route('product.index') }}" class="alert-link">Continue Shopping</a>.
        </div>
    @endif
</div>
@endsection
