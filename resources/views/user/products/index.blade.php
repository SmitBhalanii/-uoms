@extends('layouts.user')

@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item active">Products</li>
@endsection

@push('styles')
<style>
.product-image-modal {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}
.product-name-link {
    color: #007bff;
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
}
.product-name-link:hover {
    text-decoration: underline;
    color: #0056b3;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.table td {
    vertical-align: middle;
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

<!-- Products Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-boxes"></i> Product List ({{ $products->total() }} products)</h3>
            </div>
            <div class="card-body p-0">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%;" class="text-center">Sr No</th>
                                    <th style="width: 12%;">SKU</th>
                                    <th style="width: 25%;">Product Name</th>
                                    <th style="width: 12%;">Brand</th>
                                    <th style="width: 12%;">Category</th>
                                    <th style="width: 12%;" class="text-center">Available Stock</th>
                                    <th style="width: 12%;">Price</th>
                                    <th style="width: 10%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="text-center">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                        <td><span class="badge badge-secondary">{{ $product->sku }}</span></td>
                                        <td>
                                            <a href="javascript:void(0)" 
                                               class="product-name-link" 
                                               data-toggle="modal" 
                                               data-target="#productModal{{ $product->id }}">
                                                {{ $product->product_name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($product->brand)
                                                <span class="badge badge-primary">{{ $product->brand->brand_name }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge badge-info">{{ $product->category->category_name }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($product->stock_quantity > 50)
                                                <span class="badge badge-success badge-pill">
                                                    {{ $product->stock_quantity }} pcs
                                                </span>
                                            @elseif($product->stock_quantity > 10)
                                                <span class="badge badge-warning badge-pill">
                                                    {{ $product->stock_quantity }} pcs
                                                </span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge badge-danger badge-pill">
                                                    {{ $product->stock_quantity }} pcs
                                                </span>
                                            @else
                                                <span class="badge badge-danger badge-pill">
                                                    Out of Stock
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div><strong class="text-dark">₹{{ number_format($product->regular_price, 2) }}</strong></div>
                                            <div><small class="text-success">Contract: ₹{{ number_format($product->contract_price, 2) }}</small></div>
                                        </td>
                                        <td class="text-center">
                                            @if($product->stock_quantity > 0)
                                                <form action="{{ route('user.cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-ban"></i> Out of Stock
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center m-3">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <h5>No Products Found</h5>
                        <p class="mb-0">Try adjusting your search or filter criteria.</p>
                    </div>
                @endif
            </div>
            @if($products->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                        </div>
                        <div>
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Product Details Modals -->
@foreach($products as $product)
<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">
                    <i class="fas fa-box"></i> {{ $product->product_name }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-5">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->product_name }}" 
                                 class="product-image-modal img-fluid rounded shadow">
                        @else
                            <div class="text-center bg-light p-5 rounded">
                                <i class="fas fa-box fa-5x text-muted mb-3"></i>
                                <p class="text-muted">No image available</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Details -->
                    <div class="col-md-7">
                        <h4 class="mb-3">{{ $product->product_name }}</h4>
                        
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th style="width: 40%;">SKU</th>
                                <td><span class="badge badge-secondary">{{ $product->sku }}</span></td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td>{{ $product->brand->brand_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Available Stock</th>
                                <td>
                                    @if($product->stock_quantity > 50)
                                        <span class="badge badge-success">{{ $product->stock_quantity }} pieces</span>
                                    @elseif($product->stock_quantity > 10)
                                        <span class="badge badge-warning">{{ $product->stock_quantity }} pieces</span>
                                    @elseif($product->stock_quantity > 0)
                                        <span class="badge badge-danger">{{ $product->stock_quantity }} pieces</span>
                                    @else
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Regular Price</th>
                                <td><strong class="text-dark h5">₹{{ number_format($product->regular_price, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Contract Price</th>
                                <td><strong class="text-success h5">₹{{ number_format($product->contract_price, 2) }}</strong></td>
                            </tr>
                        </table>
                        
                        @if($product->description)
                            <div class="mt-3">
                                <h6><strong>Description:</strong></h6>
                                <p class="text-muted">{{ $product->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
                @if($product->stock_quantity > 0)
                    <form action="{{ route('user.cart.add', $product) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-ban"></i> Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
