@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
.small-box {
    cursor: pointer;
    transition: transform 0.2s;
}
.small-box:hover {
    transform: translateY(-5px);
}
.bg-dark-blue {
    background-color: #17a2b8 !important;
}
.bg-sky-blue {
    background-color: #3498db !important;
}
</style>
@endpush

@section('content')
    <!-- Order Status Cards -->
    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info" onclick="window.location='{{ route('admin.orders.index') }}'">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning" onclick="window.location='{{ route('admin.orders.index', ['status' => 'pending']) }}'">
                <div class="inner">
                    <h3>{{ $pendingOrders }}</h3>
                    <p>Pending Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-dark-blue" onclick="window.location='{{ route('admin.orders.index', ['status' => 'processing']) }}'">
                <div class="inner">
                    <h3>{{ $processingOrders }}</h3>
                    <p>Processing</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-sky-blue" onclick="window.location='{{ route('admin.orders.index', ['status' => 'approved']) }}'">
                <div class="inner">
                    <h3>{{ $approvedOrders }}</h3>
                    <p>Approved</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'approved']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger" onclick="window.location='{{ route('admin.orders.index', ['status' => 'rejected']) }}'">
                <div class="inner">
                    <h3>{{ $rejectedOrders }}</h3>
                    <p>Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'rejected']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success" onclick="window.location='{{ route('admin.orders.index', ['status' => 'completed']) }}'">
                <div class="inner">
                    <h3>{{ $completedOrders }}</h3>
                    <p>Completed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Lab Managers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalDepartments }}</h3>
                    <p>Total Departments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.departments.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $lowStockProducts }}</h3>
                    <p>Low Stock Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <section class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-1"></i>
                        Recent Orders
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentOrders->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No orders yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>User</th>
                                        <th>Department</th>
                                        <th>Total Items</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->department ?? 'N/A' }}</td>
                                        <td>{{ $order->total_items }}</td>
                                        <td>
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
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
