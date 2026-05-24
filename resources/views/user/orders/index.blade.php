@extends('layouts.user')

@section('page-title', 'Order History')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Order History</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Orders</h3>
                <div class="card-tools">
                    <a href="{{ route('user.orders.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> New Order
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <form method="GET" action="{{ route('user.orders.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search by order number..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('user.orders.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                @if($orders->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No orders found. 
                        <a href="{{ route('user.orders.create') }}">Place your first order</a>.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Order Number</th>
                                    <th>Date</th>
                                    <th>Total Items</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $order->total_items }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
