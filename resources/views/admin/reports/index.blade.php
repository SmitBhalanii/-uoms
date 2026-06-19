@extends('layouts.admin')

@section('page-title', 'Reports Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Reports</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.css">
<style>
.report-card {
    transition: transform 0.2s;
    cursor: pointer;
}
.report-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

<!-- Department and Products Charts -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-building"></i> Department-wise Orders</h3>
            </div>
            <div class="card-body">
                <canvas id="departmentChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box"></i> Top 10 Products</h3>
            </div>
            <div class="card-body">
                <canvas id="productsChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Monthly Orders Line Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
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
        maintainAspectRatio: true,
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

// Status Pie Chart
const statusColors = {
    'Pending': '#ffc107',
    'Processing': '#17a2b8',
    'Approved': '#3498db',
    'Rejected': '#dc3545',
    'Completed': '#28a745'
};

const statusLabels = @json($statusLabels);
const statusBackgroundColors = statusLabels.map(label => statusColors[label] || '#6c757d');

const statusPieCtx = document.getElementById('statusPieChart').getContext('2d');
new Chart(statusPieCtx, {
    type: 'pie',
    data: {
        labels: statusLabels,
        datasets: [{
            data: @json($statusData),
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
            }
        }
    }
});

// Department Bar Chart
const deptCtx = document.getElementById('departmentChart').getContext('2d');
new Chart(deptCtx, {
    type: 'bar',
    data: {
        labels: @json($departmentOrders->pluck('department')),
        datasets: [{
            label: 'Orders',
            data: @json($departmentOrders->pluck('order_count')),
            backgroundColor: '#17a2b8',
            borderColor: '#138496',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
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

// Top Products Bar Chart
const productsCtx = document.getElementById('productsChart').getContext('2d');
new Chart(productsCtx, {
    type: 'bar',
    data: {
        labels: @json($topProducts->pluck('product_name')),
        datasets: [{
            label: 'Total Ordered',
            data: @json($topProducts->pluck('total_ordered')),
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
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endpush
