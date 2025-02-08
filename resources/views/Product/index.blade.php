@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Products</h2>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 d-flex align-items-stretch mb-3">
            <div class="card w-100">
                <div class="card-img-container" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}" style="max-height: 100%; width: auto;">
                </div>
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 150px;">
                    <div>
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">${{ $product->price }}</p>
                    </div>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-grid">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-auto">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    
    </div>
</div>
@endsection
