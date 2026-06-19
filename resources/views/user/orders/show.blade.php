@extends('layouts.user')

@section('page-title', 'Order Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
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
                        <strong>Total Items:</strong><br>
                        {{ $order->total_items }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        @if($order->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($order->status == 'processing')
                            <span class="badge" style="background-color: #17a2b8; color: white;">Processing</span>
                        @elseif($order->status == 'approved')
                            <span class="badge" style="background-color: #3498db; color: white;">Approved</span>
                        @elseif($order->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-success">Completed</span>
                        @endif
                    </div>
                </div>

                @if($order->remarks)
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Your Remarks:</strong><br>
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
                                <td>{{ $item->quantity }} pieces</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Status</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="time-label">
                        <span class="bg-primary">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">Order Placed</h3>
                            <div class="timeline-body">
                                Your order has been placed successfully.
                            </div>
                        </div>
                    </div>

                    @if($order->status == 'approved' || $order->status == 'processing' || $order->status == 'completed')
                    <div>
                        <i class="fas fa-check bg-success"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">Order Approved</h3>
                            <div class="timeline-body">
                                Your order has been approved by admin.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status == 'processing' || $order->status == 'completed')
                    <div>
                        <i class="fas fa-cog bg-info"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">Processing</h3>
                            <div class="timeline-body">
                                Your order is being processed.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status == 'completed')
                    <div>
                        <i class="fas fa-flag bg-dark"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">Completed</h3>
                            <div class="timeline-body">
                                Your order has been completed.
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status == 'rejected')
                    <div>
                        <i class="fas fa-times bg-danger"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">Order Rejected</h3>
                            <div class="timeline-body">
                                Your order has been rejected.
                            </div>
                        </div>
                    </div>
                    @endif

                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
