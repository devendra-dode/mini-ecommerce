<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Mini eCommerce</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(to right, #007bff, #6610f2);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>


    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Welcome to Mini eCommerce</h1>
            <p class="lead">Explore our latest products and shop with ease.</p>
            <a href="{{ url('/products') }}" class="btn btn-light btn-lg">Shop Now</a>
        </div>
    </header>

    <!-- Featured Products -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Featured Products</h2>
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
    
    
    

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Mini eCommerce. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
