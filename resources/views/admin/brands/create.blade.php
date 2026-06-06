@extends('layouts.admin')

@section('page-title', 'Add Product Brand')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Product Brands</a></li>
    <li class="breadcrumb-item active">Add Brand</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Product Brand</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.brands.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="brand_name">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control @error('brand_name') is-invalid @enderror" value="{{ old('brand_name') }}" required>
                            @error('brand_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Brand
                        </button>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
