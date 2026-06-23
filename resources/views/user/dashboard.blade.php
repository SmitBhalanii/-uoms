@extends('layouts.user')

@section('page-title', 'Lab Manager Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('user.orders.index') }}" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingOrders }}</h3>
                    <p>Pending Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('user.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $approvedOrders }}</h3>
                    <p>Approved Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('user.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $wishlistCount }}</h3>
                    <p>Wishlist Items</p>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
                <a href="{{ route('user.wishlist.index') }}" class="small-box-footer">View Wishlist <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-8 connectedSortable">
            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Recent Orders
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.cart.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td><strong>{{ $order->order_number }}</strong></td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>{{ $order->orderItems->count() }} items</td>
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
                    @else
                        <p class="text-center text-muted">No orders yet. <a href="{{ route('user.products.index') }}">Browse products to get started</a></p>
                    @endif
                </div>
            </div>
            <!-- /.card -->

            <!-- Latest Products -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-boxes mr-1"></i>
                        Latest Products
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.products.index') }}" class="btn btn-sm btn-primary">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($latestProducts as $product)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1">{{ Str::limit($product->product_name, 30) }}</h6>
                                        <p class="card-text small mb-1">
                                            @if($product->brand)
                                                <span class="badge badge-primary">{{ $product->brand->brand_name }}</span>
                                            @endif
                                            <span class="badge badge-info">{{ $product->category->category_name }}</span>
                                        </p>
                                        <p class="card-text small mb-2">
                                            <strong>Stock: {{ $product->stock_quantity }} pieces</strong>
                                        </p>
                                        <form action="{{ route('user.cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->

        <!-- right col -->
        <section class="col-lg-4 connectedSortable">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.cart.index') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-shopping-cart"></i> My Cart
                        </a>
                        <a href="{{ route('user.products.index') }}" class="btn btn-info btn-block mb-2">
                            <i class="fas fa-boxes"></i> Browse Products
                        </a>
                        <a href="{{ route('user.wishlist.index') }}" class="btn btn-danger btn-block mb-2">
                            <i class="fas fa-heart"></i> My Wishlist
                        </a>
                        <a href="{{ route('user.orders.index') }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-history"></i> Order History
                        </a>
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <!-- User Info -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        My Information
                    </h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-user mr-1"></i> Name</strong>
                    <p class="text-muted">{{ Auth::user()->name }}</p>
                    <hr>
                    
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <hr>
                    
                    @if(Auth::user()->phone)
                        <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                        <p class="text-muted">{{ Auth::user()->phone }}</p>
                        <hr>
                    @endif
                    
                    @if(Auth::user()->department)
                        <strong><i class="fas fa-building mr-1"></i> Department</strong>
                        <p class="text-muted">{{ Auth::user()->department }}</p>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
@endsection
