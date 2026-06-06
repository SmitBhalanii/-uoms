@extends('layouts.user')

@section('page-title', 'Product Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">{{ $product->product_name }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid rounded">
                @else
                    <img src="https://via.placeholder.com/600x400?text={{ urlencode($product->product_name) }}" alt="{{ $product->product_name }}" class="img-fluid rounded">
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $product->product_name }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width: 150px;">SKU:</th>
                            <td><strong>{{ $product->sku }}</strong></td>
                        </tr>
                        <tr>
                            <th>Brand:</th>
                            <td>
                                @if($product->brand)
                                    <span class="badge badge-primary">{{ $product->brand->brand_name }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>
                                @if($product->category)
                                    <span class="badge badge-info">{{ $product->category->category_name }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Regular Price:</th>
                            <td><strong>₹{{ number_format($product->regular_price, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Contract Price:</th>
                            <td><strong class="text-success">₹{{ number_format($product->contract_price, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Available Stock:</th>
                            <td>
                                @if($product->stock_quantity > 0)
                                    <span class="badge badge-{{ $product->stock_quantity > 50 ? 'success' : 'warning' }}">
                                        {{ $product->stock_quantity }} Pieces
                                    </span>
                                @else
                                    <span class="badge badge-danger">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($product->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3">
                    <h5>Description:</h5>
                    <p>{{ $product->description ?? 'No description available.' }}</p>
                </div>

                <div class="mt-4">
                    @if(auth()->user()->hasInWishlist($product->id))
                        <button class="btn btn-success btn-lg disabled">
                            <i class="fas fa-check"></i> Already in Wishlist
                        </button>
                    @else
                        <form action="{{ route('user.wishlist.add', $product) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($relatedProducts->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Related Products</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                @if($relatedProduct->image)
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->product_name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x150?text={{ urlencode($relatedProduct->product_name) }}" class="card-img-top" alt="{{ $relatedProduct->product_name }}">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($relatedProduct->product_name, 30) }}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">{{ $relatedProduct->sku }}</small><br>
                                        <span class="badge badge-{{ $relatedProduct->stock_quantity > 0 ? 'success' : 'danger' }}">
                                            Stock: {{ $relatedProduct->stock_quantity }} Pieces
                                        </span>
                                    </p>
                                    <a href="{{ route('user.products.show', $relatedProduct) }}" class="btn btn-info btn-sm btn-block">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
