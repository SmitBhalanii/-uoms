@extends('layouts.user')

@section('page-title', 'Lab Manager Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    /* Modern Dashboard Styles */
    body {
        background: #f8f9fa;
    }

    /* Modern Stat Cards */
    .modern-stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .modern-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modern-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .modern-stat-card:hover::before {
        opacity: 1;
    }

    /* Card Gradients */
    .gradient-info { --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-warning { --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .gradient-success { --card-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .gradient-primary { --card-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .stat-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--card-gradient);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 16px;
    }

    .stat-icon-wrapper i {
        font-size: 28px;
        color: white;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 800;
        color: #2d3748;
        margin: 12px 0 4px 0;
        line-height: 1;
        animation: countUp 0.6s ease-out;
    }

    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-label {
        font-size: 14px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
    }

    .stat-footer-text {
        font-size: 13px;
        color: #4a5568;
        font-weight: 500;
    }

    .stat-footer-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7fafc;
        color: #4a5568;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .modern-stat-card:hover .stat-footer-icon {
        background: var(--card-gradient);
        color: white;
        transform: translateX(4px);
    }

    /* Modern Cards */
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .modern-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 20px 24px;
    }

    .modern-card .card-header .card-title {
        color: white;
        font-weight: 700;
        font-size: 18px;
        margin: 0;
    }

    .modern-card .card-header .card-title i {
        margin-right: 8px;
    }

    .modern-card .card-body {
        padding: 24px;
    }

    /* Modern Table */
    .modern-table {
        margin: 0;
    }

    .modern-table thead th {
        border: none;
        background: #f7fafc;
        color: #4a5568;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
    }

    .modern-table tbody td {
        border-top: 1px solid #e2e8f0;
        padding: 16px;
        vertical-align: middle;
        color: #2d3748;
        font-size: 14px;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
    }

    /* Modern Badges */
    .modern-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-pending {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-processing {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-approved {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge-rejected {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .badge-completed {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    /* Modern Buttons */
    .modern-btn {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white !important;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .modern-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .modern-btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white !important;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }

    .modern-btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 172, 254, 0.5);
    }

    .modern-btn-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white !important;
        box-shadow: 0 4px 12px rgba(67, 233, 123, 0.4);
    }

    .modern-btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 233, 123, 0.5);
    }

    .modern-btn-secondary {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #2d3748 !important;
        box-shadow: 0 4px 12px rgba(168, 237, 234, 0.4);
    }

    .modern-btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(168, 237, 234, 0.5);
    }

    .modern-btn-block {
        width: 100%;
        justify-content: center;
        margin-bottom: 12px;
    }

    /* Product Cards */
    .product-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .product-card .card-img-top {
        height: 160px;
        object-fit: cover;
    }

    .product-card .card-body {
        padding: 16px;
    }

    /* User Info Card */
    .user-info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        color: white;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        margin-bottom: 24px;
    }

    .user-info-card .card-header {
        background: transparent;
        border: none;
        padding: 0 0 16px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 16px;
    }

    .user-info-card .card-title {
        color: white;
        font-weight: 700;
        font-size: 18px;
        margin: 0;
    }

    .user-info-card strong {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
    }

    .user-info-card .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .user-info-card hr {
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Quick Actions Card */
    .quick-actions-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 24px;
        margin-bottom: 24px;
    }

    .quick-actions-card .card-header {
        background: transparent;
        border: none;
        padding: 0 0 16px 0;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .quick-actions-card .card-title {
        color: #2d3748;
        font-weight: 700;
        font-size: 18px;
        margin: 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #cbd5e0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-stat-card {
            margin-bottom: 16px;
        }

        .stat-value {
            font-size: 28px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Info boxes -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-stat-card gradient-info" onclick="window.location='{{ route('user.orders.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">View all orders</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-stat-card gradient-warning" onclick="window.location='{{ route('user.orders.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Awaiting approval</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-stat-card gradient-success" onclick="window.location='{{ route('user.orders.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $approvedOrders }}</div>
                <div class="stat-label">Approved Orders</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Successfully approved</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-stat-card gradient-primary" onclick="window.location='{{ route('user.cart.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ collect(session()->get('cart', []))->sum() }}</div>
                <div class="stat-label">Cart Items</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">View your cart</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-8">
            <!-- Recent Orders -->
            <div class="modern-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i>
                        Recent Orders
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.cart.index') }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table modern-table">
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
                                            <td><span class="badge bg-secondary">{{ $order->orderItems->count() }} items</span></td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="modern-badge badge-pending">
                                                        <i class="fas fa-circle"></i> Pending
                                                    </span>
                                                @elseif($order->status == 'processing')
                                                    <span class="modern-badge badge-processing">
                                                        <i class="fas fa-circle"></i> Processing
                                                    </span>
                                                @elseif($order->status == 'approved')
                                                    <span class="modern-badge badge-approved">
                                                        <i class="fas fa-circle"></i> Approved
                                                    </span>
                                                @elseif($order->status == 'rejected')
                                                    <span class="modern-badge badge-rejected">
                                                        <i class="fas fa-circle"></i> Rejected
                                                    </span>
                                                @elseif($order->status == 'completed')
                                                    <span class="modern-badge badge-completed">
                                                        <i class="fas fa-circle"></i> Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user.orders.show', $order) }}" class="modern-btn modern-btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <p class="mb-3">No orders yet.</p>
                            <a href="{{ route('user.products.index') }}" class="modern-btn modern-btn-primary">
                                <i class="fas fa-boxes"></i> Browse Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Latest Products -->
            <div class="modern-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-boxes"></i>
                        Latest Products
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.products.index') }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-eye"></i> View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($latestProducts as $product)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="product-card">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title mb-2" style="font-weight: 700; color: #2d3748;">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </h6>
                                        <p class="card-text small mb-2">
                                            @if($product->brand)
                                                <span class="badge bg-primary">{{ $product->brand->brand_name }}</span>
                                            @endif
                                            <span class="badge bg-info">{{ $product->category->category_name }}</span>
                                        </p>
                                        <p class="card-text small mb-2">
                                            <strong style="color: #4a5568;">Stock: {{ $product->stock_quantity }} pieces</strong>
                                        </p>
                                        <form action="{{ route('user.cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="modern-btn modern-btn-primary modern-btn-block">
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
        </section>

        <!-- Right col -->
        <section class="col-lg-4">
            <!-- Quick Actions -->
            <div class="quick-actions-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h3>
                </div>
                <div class="card-body p-0">
                    <a href="{{ route('user.cart.index') }}" class="modern-btn modern-btn-primary modern-btn-block">
                        <i class="fas fa-shopping-cart"></i> My Cart
                    </a>
                    <a href="{{ route('user.products.index') }}" class="modern-btn modern-btn-info modern-btn-block">
                        <i class="fas fa-boxes"></i> Browse Products
                    </a>
                    <a href="{{ route('user.orders.index') }}" class="modern-btn modern-btn-success modern-btn-block">
                        <i class="fas fa-history"></i> Order History
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="modern-btn modern-btn-secondary modern-btn-block">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                </div>
            </div>

            <!-- User Info -->
            <div class="user-info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> My Information
                    </h3>
                </div>
                <div class="card-body p-0">
                    <strong><i class="fas fa-user me-2"></i> Name</strong>
                    <p class="text-muted mb-3">{{ Auth::user()->name }}</p>
                    
                    <strong><i class="fas fa-envelope me-2"></i> Email</strong>
                    <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                    
                    @if(Auth::user()->phone)
                        <strong><i class="fas fa-phone me-2"></i> Phone</strong>
                        <p class="text-muted mb-3">{{ Auth::user()->phone }}</p>
                    @endif
                    
                    @if(Auth::user()->department)
                        <strong><i class="fas fa-building me-2"></i> Department</strong>
                        <p class="text-muted mb-0">{{ Auth::user()->department }}</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
