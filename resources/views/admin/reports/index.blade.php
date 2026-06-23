@extends('layouts.admin')

@section('page-title', 'Reports Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Reports</li>
@endsection

@push('styles')
<style>
.report-card {
    transition: transform 0.2s;
    cursor: pointer;
}
.report-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.chart-container {
    position: relative;
    min-height: 300px;
}
.no-data-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #999;
}
</style>
@endpush

@section('content')
<div class="row">
    <!-- Report Forms Row -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Monthly Report</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.monthly') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-control @error('month') is-invalid @enderror" required>
                                    <option value="">Select Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('month', date('n')) == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('month')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year <span class="text-danger">*</span></label>
                                <select name="year" class="form-control @error('year') is-invalid @enderror" required>
                                    <option value="">Select Year</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}" {{ old('year', date('Y')) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('year')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-eye"></i> View Report
                        </button>
                        <button type="submit" name="export" value="pdf" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title"><i class="fas fa-calendar-day"></i> Custom Date Report</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.custom') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From Date <span class="text-danger">*</span></label>
                                <input type="date" name="from_date" class="form-control @error('from_date') is-invalid @enderror" value="{{ old('from_date') }}" required>
                                @error('from_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>To Date <span class="text-danger">*</span></label>
                                <input type="date" name="to_date" class="form-control @error('to_date') is-invalid @enderror" value="{{ old('to_date') }}" required>
                                @error('to_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-eye"></i> View Report
                        </button>
                        <button type="submit" name="export" value="pdf" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quick Report Links -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="card report-card" onclick="window.location='{{ route('admin.reports.top-products') }}'">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                <h5>Top Selling Products</h5>
                <p class="text-muted">View highest ordered products</p>
                <a href="{{ route('admin.reports.top-products') }}" class="btn btn-sm btn-primary">View Report</a>
                <a href="{{ route('admin.reports.top-products', ['export' => 'pdf']) }}" class="btn btn-sm btn-danger">Export PDF</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="card report-card" onclick="window.location='{{ route('admin.reports.status', 'pending') }}'">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                <h5>Pending Orders</h5>
                <p class="text-muted">View all pending orders</p>
                <a href="{{ route('admin.reports.status', 'pending') }}" class="btn btn-sm btn-warning">View Report</a>
                <a href="{{ route('admin.reports.status', ['status' => 'pending', 'export' => 'pdf']) }}" class="btn btn-sm btn-danger">Export PDF</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="card report-card" onclick="window.location='{{ route('admin.reports.status', 'completed') }}'">
            <div class="card-body text-center">
                <i class="fas fa-check-double fa-3x text-success mb-3"></i>
                <h5>Completed Orders</h5>
                <p class="text-muted">View all completed orders</p>
                <a href="{{ route('admin.reports.status', 'completed') }}" class="btn btn-sm btn-success">View Report</a>
                <a href="{{ route('admin.reports.status', ['status' => 'completed', 'export' => 'pdf']) }}" class="btn btn-sm btn-danger">Export PDF</a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Monthly Orders Trend</h3>
            </div>
            <div class="card-body">
                <canvas id="ordersChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Orders by Status</h3>
            </div>
            <div class="card-body">
                <canvas id="statusPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Products Chart -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box"></i> Top 10 Products</h3>
            </div>
            <div class="card-body">
                <canvas id="productsChart" height="60"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart data from controller
    const chartLabels = @json($chartLabels ?? []);
    const chartData = @json($chartData ?? []);
    const statusLabels = @json($statusLabels ?? []);
    const statusData = @json($statusData ?? []);
    const productLabels = @json($topProducts->pluck('product_name') ?? []);
    const productData = @json($topProducts->pluck('total_ordered') ?? []);

    // Status color mapping
    const statusColors = {
        'Pending': '#ffc107',
        'Processing': '#17a2b8',
        'Approved': '#3498db',
        'Rejected': '#dc3545',
        'Completed': '#28a745'
    };

    // 1. Monthly Orders Line Chart
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        if (chartLabels.length > 0 && chartData.length > 0) {
            new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Orders',
                        data: chartData,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
        } else {
            ordersCtx.parentElement.innerHTML = '<div class="no-data-message"><i class="fas fa-chart-line fa-3x mb-2"></i><br>No data available</div>';
        }
    }

    // 2. Status Pie Chart
    const statusPieCtx = document.getElementById('statusPieChart');
    if (statusPieCtx) {
        if (statusLabels.length > 0 && statusData.length > 0) {
            const statusBackgroundColors = statusLabels.map(label => statusColors[label] || '#6c757d');
            
            new Chart(statusPieCtx, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: statusBackgroundColors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        } else {
            statusPieCtx.parentElement.innerHTML = '<div class="no-data-message"><i class="fas fa-chart-pie fa-3x mb-2"></i><br>No data available</div>';
        }
    }

    // 3. Top Products Horizontal Bar Chart
    const productsCtx = document.getElementById('productsChart');
    if (productsCtx) {
        if (productLabels.length > 0 && productData.length > 0) {
            new Chart(productsCtx, {
                type: 'bar',
                data: {
                    labels: productLabels,
                    datasets: [{
                        label: 'Total Ordered',
                        data: productData,
                        backgroundColor: '#28a745',
                        borderColor: '#218838',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
        } else {
            productsCtx.parentElement.innerHTML = '<div class="no-data-message"><i class="fas fa-box fa-3x mb-2"></i><br>No data available</div>';
        }
    }
});
</script>
@endpush
