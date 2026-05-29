@extends('layouts.user')

@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('user.products.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
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

<div class="row">
    @forelse($products as $product)
        <div class="col-md-4 col-sm-6">
            <div class="card">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400x200?text={{ urlencode($product->product_name) }}" class="card-img-top" alt="{{ $product->product_name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->product_name }}</h5>
                    <p class="card-text">
                        <small class="text-muted">{{ $product->product_code }}</small><br>
                        <span class="badge badge-info">{{ $product->category->category_name ?? 'N/A' }}</span>
                        <span class="badge badge-secondary">Stock: {{ $product->stock_quantity }}</span>
                    </p>
                    <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.products.show', $product) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    @if(auth()->user()->hasInWishlist($product->id))
                        <span class="btn btn-success btn-sm disabled">
                            <i class="fas fa-check"></i> In Wishlist
                        </span>
                    @else
                        <form action="{{ route('user.wishlist.add', $product) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No products found.
            </div>
        </div>
    @endforelse
</div>

<div class="row mt-3">
    <div class="col-12">
        {{ $products->links() }}
    </div>
</div>
@endsection
