@extends('layouts.admin')

@section('page-title', 'Product Brands')

@section('breadcrumb')
    <li class="breadcrumb-item active">Product Brands</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Brand List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Brand
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.brands.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Search brands..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Sr No</th>
                                <th>Brand Name</th>
                                <th>Products Count</th>
                                <th>Status</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ ($brands->currentPage() - 1) * $brands->perPage() + $loop->iteration }}</td>
                                    <td>{{ $brand->brand_name }}</td>
                                    <td><span class="badge badge-info">{{ $brand->products_count }}</span></td>
                                    <td>
                                        @if($brand->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No brands found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
