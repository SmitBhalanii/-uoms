@extends('layouts.admin')

@section('page-title', 'Top Selling Products Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
    <li class="breadcrumb-item active">Top Products</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">
            <i class="fas fa-trophy"></i> 
            Top 10 Selling Products
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.reports.top-products', ['export' => 'pdf']) }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($topProducts->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No products data available.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Rank</th>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Total Ordered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $index => $product)
                        <tr>
                            <td>
                                @if($index == 0)
                                    <i class="fas fa-trophy text-warning"></i> #1
                                @elseif($index == 1)
                                    <i class="fas fa-medal text-secondary"></i> #2
                                @elseif($index == 2)
                                    <i class="fas fa-medal text-danger"></i> #3
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td><strong>{{ $product->sku }}</strong></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td><span class="badge badge-success">{{ $product->total_ordered }} pcs</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
