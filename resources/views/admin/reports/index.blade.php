@extends('layouts.admin')

@section('page-title', 'Reports & Analytics')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')
<div class="row">
    <!-- Monthly Orders Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-2"></i>
                    Orders Per Month
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyOrdersChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Distribution Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Order Status Distribution
                </h3>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Orders Report -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Monthly Orders Report
                </h3>
            </div>
            <div class="card-body">
                @if($monthlyOrders->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No orders data available.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Total Orders</th>
                                    <th>Total Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyOrders as $report)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($report->month . '-01')->format('F Y') }}</td>
                                    <td>{{ $report->total_orders }}</td>
                                    <td>{{ $report->total_items }}</td>
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

<!-- Department-wise Orders -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-building mr-2"></i>
                    Department-wise Orders
                </h3>
            </div>
            <div class="card-body">
                @if($departmentOrders->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No department data available.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Department</th>
                                    <th>Total Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentOrders as $dept)
                                <tr>
                                    <td>{{ $dept->department }}</td>
                                    <td><span class="badge badge-primary">{{ $dept->order_count }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status-wise Orders -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks mr-2"></i>
                    Status-wise Orders
                </h3>
            </div>
            <div class="card-body">
                @if($statusOrders->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No status data available.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusOrders as $status)
                                <tr>
                                    <td>
                                        @if($status->status == 'pending')
                                            <span class="badge badge-warning">{{ ucfirst($status->status) }}</span>
                                        @elseif($status->status == 'approved')
                                            <span class="badge badge-success">{{ ucfirst($status->status) }}</span>
                                        @elseif($status->status == 'rejected')
                                            <span class="badge badge-danger">{{ ucfirst($status->status) }}</span>
                                        @elseif($status->status == 'processing')
                                            <span class="badge badge-info">{{ ucfirst($status->status) }}</span>
                                        @elseif($status->status == 'completed')
                                            <span class="badge badge-dark">{{ ucfirst($status->status) }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $status->count }}</strong></td>
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

<!-- Top Ordered Products -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-star mr-2"></i>
                    Top 10 Ordered Products
                </h3>
            </div>
            <div class="card-body">
                @if($topProducts->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No products data available.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Category</th>
                                    <th>Total Ordered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-success">{{ $product->total_ordered }}</span></td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Monthly Orders Chart
    const monthlyCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Orders',
                data: @json($chartData),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusData),
                backgroundColor: [
                    '#ffc107',
                    '#28a745',
                    '#dc3545',
                    '#17a2b8',
                    '#343a40'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right'
                }
            }
        }
    });
</script>
@endpush
