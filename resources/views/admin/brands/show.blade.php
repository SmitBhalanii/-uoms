@extends('layouts.admin')

@section('page-title', 'Brand Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Product Brands</a></li>
    <li class="breadcrumb-item active">Brand Details</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Brand Details: {{ $brand->brand_name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Brand Name</th>
                                <td>{{ $brand->brand_name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $brand->description ?? 'No description available.' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($brand->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Products Count</th>
                                <td><span class="badge badge-info">{{ $brand->products_count }}</span></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $brand->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $brand->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Brand
                    </a>
                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">
                            <i class="fas fa-trash"></i> Delete Brand
                        </button>
                    </form>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
