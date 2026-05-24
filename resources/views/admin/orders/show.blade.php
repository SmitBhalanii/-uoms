@extends('layouts.admin')

@section('page-title', 'Order Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Information</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Order Number:</strong><br>
                        <span class="text-primary">{{ $order->order_number }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Order Date:</strong><br>
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>User Name:</strong><br>
                        {{ $order->user->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong><br>
                        {{ $order->user->email }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Department:</strong><br>
                        {{ $order->user->department ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Phone:</strong><br>
                        {{ $order->user->phone ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total Items:</strong><br>
                        {{ $order->total_items }}
                    </div>
                    <div class="col-md-6">
                        <strong>Current Status:</strong><br>
                        @if($order->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($order->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($order->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @elseif($order->status == 'processing')
                            <span class="badge badge-info">Processing</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-dark">Completed</span>
                        @endif
                    </div>
                </div>

                @if($order->remarks)
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>User Remarks:</strong><br>
                        <p class="text-muted">{{ $order->remarks }}</p>
                    </div>
                </div>
                @endif

                <hr>

                <h5 class="mb-3">Ordered Products</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="80">Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th width="100">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
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
                                <td>{{ $item->quantity }} {{ $item->product->unit->short_name ?? 'pcs' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Order Status</h3>
            </div>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" 
                                id="status" 
                                class="form-control @error('status') is-invalid @enderror" 
                                required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="remarks">Admin Remarks</label>
                        <textarea name="remarks" 
                                  id="remarks" 
                                  class="form-control @error('remarks') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Add remarks or notes...">{{ old('remarks', $order->remarks) }}</textarea>
                        @error('remarks')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <small>User will see the updated status in their order history.</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Guide</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <span class="badge badge-warning">Pending</span> - Order received, awaiting review
                    </li>
                    <li class="mb-2">
                        <span class="badge badge-success">Approved</span> - Order approved by admin
                    </li>
                    <li class="mb-2">
                        <span class="badge badge-danger">Rejected</span> - Order rejected
                    </li>
                    <li class="mb-2">
                        <span class="badge badge-info">Processing</span> - Order being prepared
                    </li>
                    <li class="mb-2">
                        <span class="badge badge-dark">Completed</span> - Order fulfilled
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
