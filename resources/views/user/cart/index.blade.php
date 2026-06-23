@extends('layouts.user')

@section('page-title', 'My Cart')

@section('breadcrumb')
    <li class="breadcrumb-item active">Cart</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-shopping-cart"></i> Shopping Cart
                    @if($totalItems > 0)
                        <span class="badge badge-light">{{ $totalItems }} Item(s)</span>
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @if(count($cartItems) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Image</th>
                                    <th style="width: 25%;">Product</th>
                                    <th style="width: 15%;">SKU</th>
                                    <th style="width: 10%;">Available</th>
                                    <th style="width: 15%;">Price</th>
                                    <th style="width: 15%;">Quantity</th>
                                    <th style="width: 10%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    @php
                                        $product = $item['product'];
                                        $quantity = $item['quantity'];
                                    @endphp
                                    <tr>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-box fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $product->product_name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                @if($product->brand)
                                                    {{ $product->brand->brand_name }}
                                                @endif
                                            </small>
                                        </td>
                                        <td><span class="badge badge-secondary">{{ $product->sku }}</span></td>
                                        <td>
                                            @if($product->stock_quantity >= $quantity)
                                                <span class="badge badge-success">{{ $product->stock_quantity }} pcs</span>
                                            @else
                                                <span class="badge badge-danger">Only {{ $product->stock_quantity }} left!</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>₹{{ number_format($product->contract_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <form action="{{ route('user.cart.update') }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="input-group" style="width: 120px;">
                                                    <input type="number" 
                                                           name="quantity" 
                                                           value="{{ $quantity }}" 
                                                           min="1" 
                                                           max="{{ $product->stock_quantity }}" 
                                                           class="form-control form-control-sm"
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('user.cart.remove', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove this item from cart?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('user.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                        <form action="{{ route('user.cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Clear entire cart?')">
                                <i class="fas fa-trash-alt"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                        <h4>Your cart is empty</h4>
                        <p class="text-muted">Add products to your cart to place an order.</p>
                        <a href="{{ route('user.products.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0"><i class="fas fa-file-invoice"></i> Order Summary</h3>
            </div>
            <div class="card-body">
                @if(count($cartItems) > 0)
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Total Items:</strong></td>
                            <td class="text-right"><strong>{{ $totalItems }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total Products:</strong></td>
                            <td class="text-right"><strong>{{ count($cartItems) }}</strong></td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <form action="{{ route('user.orders.place') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="remarks">Remarks (Optional)</label>
                            <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3" placeholder="Any special instructions or notes...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block btn-lg">
                            <i class="fas fa-check-circle"></i> Place Order
                        </button>
                    </form>
                @else
                    <p class="text-muted text-center mb-0">No items in cart</p>
                @endif
            </div>
        </div>
        
        <!-- Cart Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h6><i class="fas fa-info-circle text-info"></i> Important Information</h6>
                <ul class="small mb-0">
                    <li>Review quantities before placing order</li>
                    <li>Orders cannot be modified after submission</li>
                    <li>Admin will review and approve your order</li>
                    <li>Email notification will be sent upon approval</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
