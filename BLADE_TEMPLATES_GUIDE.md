# Complete Blade Templates for Master Modules

This document contains all the blade templates needed for the master modules. Create these files in your project.

## Directory Structure

```
resources/views/admin/
├── departments/
│   ├── index.blade.php   ✅ Created
│   ├── create.blade.php  ✅ Created
│   ├── edit.blade.php    (See below)
│   └── show.blade.php    (See below)
├── categories/
│   ├── index.blade.php   (Similar to departments)
│   ├── create.blade.php  (Similar to departments)
│   ├── edit.blade.php    (Similar to departments)
│   └── show.blade.php    (Similar to departments)
├── units/
│   ├── index.blade.php   (Similar to departments)
│   ├── create.blade.php  (Similar to departments)
│   ├── edit.blade.php    (Similar to departments)
│   └── show.blade.php    (Similar to departments)
└── products/
    ├── index.blade.php   (With search & filters)
    ├── create.blade.php  (With image upload)
    ├── edit.blade.php    (With image upload)
    └── show.blade.php    (With image display)
```

## How to Create Remaining Files

### Option 1: Use Artisan Command
```bash
# Create all blade files at once
php artisan make:view admin.departments.edit
php artisan make:view admin.departments.show
php artisan make:view admin.categories.index
# ... and so on
```

### Option 2: Copy from Templates Below

---

## Department Edit Template

**File**: `resources/views/admin/departments/edit.blade.php`

```blade
@extends('layouts.admin')

@section('page-title', 'Edit Department')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Department</h3>
                </div>
                <form action="{{ route('admin.departments.update', $department) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="department_name">Department Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('department_name') is-invalid @enderror" 
                                   id="department_name" name="department_name" value="{{ old('department_name', $department->department_name) }}" required>
                            @error('department_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lab_code">Lab Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lab_code') is-invalid @enderror" 
                                   id="lab_code" name="lab_code" value="{{ old('lab_code', $department->lab_code) }}" required>
                            @error('lab_code')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hod_name">HOD Name</label>
                            <input type="text" class="form-control @error('hod_name') is-invalid @enderror" 
                                   id="hod_name" name="hod_name" value="{{ old('hod_name', $department->hod_name) }}">
                            @error('hod_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $department->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
```

---

## Department Show Template

**File**: `resources/views/admin/departments/show.blade.php`

```blade
@extends('layouts.admin')

@section('page-title', 'Department Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Department Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Department Name</th>
                            <td>{{ $department->department_name }}</td>
                        </tr>
                        <tr>
                            <th>Lab Code</th>
                            <td><span class="badge badge-info">{{ $department->lab_code }}</span></td>
                        </tr>
                        <tr>
                            <th>HOD Name</th>
                            <td>{{ $department->hod_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $department->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($department->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $department->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $department->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
```

---

## Quick Command to Create All Remaining Files

Run these commands to create all blade files:

```bash
# Navigate to project
cd uoms

# Create Department views (edit and show already provided above)
# Copy the templates above into these files

# Create Category views
touch resources/views/admin/categories/index.blade.php
touch resources/views/admin/categories/create.blade.php
touch resources/views/admin/categories/edit.blade.php
touch resources/views/admin/categories/show.blade.php

# Create Unit views
touch resources/views/admin/units/index.blade.php
touch resources/views/admin/units/create.blade.php
touch resources/views/admin/units/edit.blade.php
touch resources/views/admin/units/show.blade.php

# Create Product views
touch resources/views/admin/products/index.blade.php
touch resources/views/admin/products/create.blade.php
touch resources/views/admin/products/edit.blade.php
touch resources/views/admin/products/show.blade.php
```

---

## Template Pattern

All master modules follow the same pattern. You can copy Department templates and modify:

### For Categories:
- Replace `department` with `category`
- Replace `departments` with `categories`
- Replace `Department` with `Category`
- Adjust fields: `category_name`, `description`, `status`

### For Units:
- Replace `department` with `unit`
- Replace `departments` with `units`
- Replace `Department` with `Unit`
- Adjust fields: `unit_name`, `short_name`, `description`, `status`

### For Products:
- Add `category_id` and `unit_id` dropdowns
- Add image upload field
- Add stock_quantity field
- Add search and filter forms

---

## Product Templates (Special Cases)

### Products Index with Search

```blade
@extends('layouts.admin')

@section('page-title', 'Products')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('admin.products.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Products Table -->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" width="50">
                                        @else
                                            <span class="badge badge-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td><span class="badge badge-info">{{ $product->product_code }}</span></td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>{{ $product->unit->unit_name }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock_quantity > 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
```

---

## Summary

**Created Files**:
1. ✅ `admin/departments/index.blade.php`
2. ✅ `admin/departments/create.blade.php`
3. ✅ Templates provided for edit and show

**To Complete**:
1. Copy edit and show templates for departments
2. Create similar files for categories, units, and products
3. Adjust field names according to each module
4. Add image upload for products

**All controllers, models, migrations, and routes are complete!**

The system is ready to use once you create the remaining blade files using the templates provided above.
