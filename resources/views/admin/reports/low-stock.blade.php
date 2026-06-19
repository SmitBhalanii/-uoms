@extends('layouts.admin')

@section('page-title', 'Low Stock Products Report')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
    <li class="breadcrumb-item active">Low Stock Products</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Products Report</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.reports.low-stock', ['export' => 'pdf']) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($lowStockProducts->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> The following products have stock quantity of 10 pieces or less. Please reorder soon.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 60px;">Sr No</th>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Stock Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $index => $product)
                                    <tr class="{{ $product->stock_quantity == 0 ? 'table-danger' : ($product->stock_quantity <= 5 ? 'table-warning' : '') }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $product->sku }}</strong></td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->brand->brand_name ?? 'N/A' }}</td>
                                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($product->stock_quantity == 0)
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Out of Stock
                                                </span>
                                            @elseif($product->stock_quantity <= 5)
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> {{ $product->stock_quantity }} pieces (Critical)
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-exclamation-circle"></i> {{ $product->stock_quantity }} pieces (Low)
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm" title="View Product">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Low Stock Products</span>
                                    <span class="info-box-number">{{ $lowStockProducts->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Out of Stock</span>
                                    <span class="info-box-number">{{ $lowStockProducts->where('stock_quantity', 0)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-orange">
                                <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Critical Stock (≤5)</span>
                                    <span class="info-box-number">{{ $lowStockProducts->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-success text-center py-5">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h4>Excellent Stock Management!</h4>
                        <p class="mb-0">All products are well stocked. No products have stock quantity of 10 pieces or less.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
