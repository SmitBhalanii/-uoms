@extends('layouts.admin')

@section('page-title', ucfirst($status) . ' Orders Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
    <li class="breadcrumb-item active">{{ ucfirst($status) }} Orders</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header 
        @if($status == 'pending') bg-warning
        @elseif($status == 'processing') bg-info
        @elseif($status == 'approved') bg-primary
        @elseif($status == 'rejected') bg-danger
        @elseif($status == 'completed') bg-success
        @endif">
        <h3 class="card-title">
            @if($status == 'pending')
                <i class="fas fa-clock"></i>
            @elseif($status == 'processing')
                <i class="fas fa-spinner"></i>
            @elseif($status == 'approved')
                <i class="fas fa-check-circle"></i>
            @elseif($status == 'rejected')
                <i class="fas fa-times-circle"></i>
            @elseif($status == 'completed')
                <i class="fas fa-check-double"></i>
            @endif
            {{ ucfirst($status) }} Orders Report
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.reports.status', ['status' => $status, 'export' => 'pdf']) }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total {{ ucfirst($status) }} Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalQuantity }}</h3>
                        <p>Total Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        @if($orders->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No {{ $status }} orders found.
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
                            <th>Date</th>
                            <th>Action</th>
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
@endsection
