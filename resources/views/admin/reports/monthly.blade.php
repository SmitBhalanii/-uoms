@extends('layouts.admin')

@section('page-title', 'Monthly Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
    <li class="breadcrumb-item active">Monthly Report</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">
            <i class="fas fa-calendar-alt"></i> 
            Monthly Report - {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
        </h3>
        <div class="card-tools">
            <form action="{{ route('admin.reports.monthly') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="export" value="pdf">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalQuantity }}</h3>
                        <p>Total Quantity</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Unique Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $statusSummary->count() }}</h3>
                        <p>Status Types</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <h5><i class="fas fa-chart-pie"></i> Status Summary</h5>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusSummary as $status => $count)
                        <tr>
                            <td>
                                @if($status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($status == 'processing')
                                    <span class="badge" style="background-color: #17a2b8; color: white;">Processing</span>
                                @elseif($status == 'approved')
                                    <span class="badge" style="background-color: #3498db; color: white;">Approved</span>
                                @elseif($status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @elseif($status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @endif
                            </td>
                            <td>{{ $count }}</td>
                            <td>{{ $totalOrders > 0 ? number_format(($count / $totalOrders) * 100, 2) : 0 }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Orders Table -->
        <h5><i class="fas fa-list"></i> Order Details</h5>
        @if($orders->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No orders found for this period.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr No</th>
                            <th>Order Number</th>
                            <th>Lab Manager</th>
                            <th>Department</th>
                            <th>Total Items</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
