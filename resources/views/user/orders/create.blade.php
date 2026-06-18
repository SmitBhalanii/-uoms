@extends('layouts.user')

@section('page-title', 'Place New Order')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.wishlist.index') }}">Wishlist</a></li>
    <li class="breadcrumb-item active">Place Order</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Place New Order</h3>
            </div>
            <form action="{{ route('user.orders.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if($wishlistItems->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Your wishlist is empty. 
                            <a href="{{ route('user.products.index') }}">Browse products</a> to add items.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="80">Image</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th width="150">Available Stock</th>
                                        <th width="150">Quantity <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlistItems as $item)
                                    <tr>
                                        <td>
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->product_name }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/60" 
                                                     alt="No Image" 
                                                     class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $item->product->product_name }}</strong><br>
                                            <small class="text-muted">{{ $item->product->product_code }}</small>
                                        </td>
                                        <td>{{ $item->product->category->category_name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $item->product->stock_quantity }} pieces
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="quantities[{{ $item->product->id }}]" 
                                                   class="form-control" 
                                                   min="1" 
                                                   max="{{ $item->product->stock_quantity }}" 
                                                   value="1" 
                                                   required>
                                            @error('quantities.' . $item->product->id)
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group mt-3">
                            <label for="remarks">Remarks (Optional)</label>
                            <textarea name="remarks" 
                                      id="remarks" 
                                      class="form-control @error('remarks') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Add any special instructions or notes...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Note:</strong> After placing the order, your wishlist will be cleared automatically.
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.wishlist.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Wishlist
                    </a>
                    @if(!$wishlistItems->isEmpty())
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fas fa-check"></i> Place Order
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
