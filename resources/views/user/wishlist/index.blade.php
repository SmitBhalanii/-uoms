@extends('layouts.user')

@section('page-title', 'My Wishlist')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Wishlist</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Wishlist</h3>
                <div class="card-tools">
                    <a href="{{ route('user.products.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add More Products
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($wishlists->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Your wishlist is empty. 
                        <a href="{{ route('user.products.index') }}">Browse products</a> to add items.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Available Stock</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wishlists as $wishlist)
                                <tr>
                                    <td>
                                        @if($wishlist->product->image)
                                            <img src="{{ asset('storage/' . $wishlist->product->image) }}" 
                                                 alt="{{ $wishlist->product->product_name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/60" 
                                                 alt="No Image" 
                                                 class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $wishlist->product->product_name }}</strong><br>
                                        <small class="text-muted">{{ $wishlist->product->product_code }}</small>
                                    </td>
                                    <td>{{ $wishlist->product->category->category_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($wishlist->product->stock_quantity > 0)
                                            <span class="badge badge-success">
                                                {{ $wishlist->product->stock_quantity }} {{ $wishlist->product->unit->short_name ?? 'pcs' }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('user.wishlist.remove', $wishlist) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Remove this product from wishlist?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $wishlists->links() }}
                    </div>

                    <div class="mt-4 text-right">
                        <a href="{{ route('user.orders.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-cart"></i> Place Order from Wishlist
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
