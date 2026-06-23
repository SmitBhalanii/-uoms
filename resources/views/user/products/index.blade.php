@extends('layouts.user')

@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item active">Products</li>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}
.product-image {
    height: 220px;
    object-fit: cover;
    background: #f8f9fa;
}
.product-body {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-info {
    flex: 1;
}
.price-section {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}
.badge-stock {
    font-size: 0.85rem;
}
</style>
@endpush

@section('content')
<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('user.products.index') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by product name or SKU..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('user.products.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row">
    @forelse($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card product-card shadow-sm">
                <!-- Product Image -->
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->product_name }}">
                @else
                    <div class="product-image d-flex align-items-center justify-content-center bg-light">
                        <i class="fas fa-box fa-4x text-muted"></i>
                    </div>
                @endif
                
                <!-- Product Body -->
                <div class="card-body product-body">
                    <div class="product-info">
                        <!-- Product Name -->
                        <h5 class="card-title mb-2">{{ Str::limit($product->product_name, 50) }}</h5>
                        
                        <!-- SKU -->
                        <p class="text-muted mb-2">
                            <small><strong>SKU:</strong> {{ $product->sku }}</small>
                        </p>
                        
                        <!-- Brand & Category -->
                        <div class="mb-2">
                            @if($product->brand)
                                <span class="badge badge-primary">
                                    <i class="fas fa-tag"></i> {{ $product->brand->brand_name }}
                                </span>
                            @endif
                            @if($product->category)
                                <span class="badge badge-info">
                                    <i class="fas fa-folder"></i> {{ $product->category->category_name }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="mb-2">
                            @if($product->stock_quantity > 50)
                                <span class="badge badge-success badge-stock">
                                    <i class="fas fa-check-circle"></i> {{ $product->stock_quantity }} Pieces Available
                                </span>
                            @elseif($product->stock_quantity > 10)
                                <span class="badge badge-warning badge-stock">
                                    <i class="fas fa-exclamation-circle"></i> {{ $product->stock_quantity }} Pieces Available
                                </span>
                            @elseif($product->stock_quantity > 0)
                                <span class="badge badge-danger badge-stock">
                                    <i class="fas fa-exclamation-triangle"></i> Only {{ $product->stock_quantity }} Left!
                                </span>
                            @else
                                <span class="badge badge-danger badge-stock">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section">
                        <p class="mb-1">
                            <strong class="text-dark h5">₹{{ number_format($product->regular_price, 2) }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-success">
                                <i class="fas fa-handshake"></i> Contract: ₹{{ number_format($product->contract_price, 2) }}
                            </small>
                        </p>
                    </div>
                </div>
                
                <!-- Card Footer -->
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.products.show', $product) }}" class="btn btn-info btn-sm flex-fill mr-1">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        @if($product->stock_quantity > 0)
                            <form action="{{ route('user.cart.add', $product) }}" method="POST" class="flex-fill ml-1">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm flex-fill ml-1" disabled>
                                <i class="fas fa-ban"></i> Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>No Products Found</h4>
                <p class="mb-0">Try adjusting your search or filter criteria.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="row mt-4">
    <div class="col-12 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endif
@endsection
