@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')

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
    .gradient-primary { --card-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .gradient-success { --card-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .gradient-danger { --card-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .gradient-secondary { --card-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
    .gradient-dark { --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-teal { --card-gradient: linear-gradient(135deg, #0ba360 0%, #3cba92 100%); }

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

    /* Modern Table Card */
    .modern-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
    }

    .modern-table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 20px 24px;
    }

    .modern-table-card .card-header .card-title {
        color: white;
        font-weight: 700;
        font-size: 18px;
        margin: 0;
    }

    .modern-table-card .card-header .card-title i {
        margin-right: 8px;
    }

    .modern-table-card .card-body {
        padding: 24px;
    }

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
        transform: scale(1.01);
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

    .modern-badge i {
        font-size: 10px;
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

    /* Modern Button */
    .modern-btn {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .modern-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .modern-btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }

    .modern-btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 172, 254, 0.5);
        color: white;
    }

    /* Alert Modern */
    .modern-alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    /* Animations */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-value {
        animation: countUp 0.6s ease-out;
    }

    /* Spacing */
    .dashboard-section {
        margin-bottom: 32px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-stat-card {
            margin-bottom: 16px;
        }

        .stat-value {
            font-size: 28px;
        }

        .stat-icon-wrapper {
            width: 56px;
            height: 56px;
        }

        .stat-icon-wrapper i {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Order Status Cards -->
    <div class="row dashboard-section">
        <!-- Total Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-info" onclick="window.location='{{ route('admin.orders.index') }}'">
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

        <!-- Pending Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-warning" onclick="window.location='{{ route('admin.orders.index', ['status' => 'pending']) }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pending</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Needs attention</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Processing Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-primary" onclick="window.location='{{ route('admin.orders.index', ['status' => 'processing']) }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-value">{{ $processingOrders }}</div>
                <div class="stat-label">Processing</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">In progress</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-dark" onclick="window.location='{{ route('admin.orders.index', ['status' => 'approved']) }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $approvedOrders }}</div>
                <div class="stat-label">Approved</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Approved orders</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-danger" onclick="window.location='{{ route('admin.orders.index', ['status' => 'rejected']) }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $rejectedOrders }}</div>
                <div class="stat-label">Rejected</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Not approved</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="modern-stat-card gradient-success" onclick="window.location='{{ route('admin.orders.index', ['status' => 'completed']) }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-value">{{ $completedOrders }}</div>
                <div class="stat-label">Completed</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Successfully done</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row - System Stats -->
    <div class="row dashboard-section">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="modern-stat-card gradient-teal" onclick="window.location='{{ route('admin.users.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Lab Managers</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Manage users</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="modern-stat-card gradient-primary" onclick="window.location='{{ route('admin.departments.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-value">{{ $totalDepartments }}</div>
                <div class="stat-label">Departments</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">View departments</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="modern-stat-card gradient-secondary" onclick="window.location='{{ route('admin.products.index') }}'">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Products</div>
                <div class="stat-footer">
                    <span class="stat-footer-text">Manage inventory</span>
                    <div class="stat-footer-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="modern-table-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Recent Orders
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-eye"></i>
                            View All Orders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentOrders->isEmpty())
                        <div class="alert alert-info modern-alert">
                            <i class="fas fa-info-circle me-2"></i> No orders yet. Orders will appear here once users start placing them.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table modern-table">
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=667eea&color=fff&size=32" 
                                                     class="rounded-circle me-2" 
                                                     style="width: 32px; height: 32px;">
                                                {{ $order->user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $order->user->department ?? 'N/A' }}</td>
                                        <td><span class="badge bg-secondary">{{ $order->total_items }} items</span></td>
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
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="modern-btn modern-btn-info">
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
        </div>
    </div>
@endsection
