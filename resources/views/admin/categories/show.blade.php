@extends('layouts.admin')
@section('page-title', 'Category Details')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
<li class="breadcrumb-item active">Details</li>
@endsection
@section('content')
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Category Information</h3></div>
<div class="card-body"><table class="table table-bordered">
<tr><th width="200">Category Name</th><td>{{ $category->category_name }}</td></tr>
<tr><th>Description</th><td>{{ $category->description ?? 'N/A' }}</td></tr>
<tr><th>Products Count</th><td><span class="badge badge-info">{{ $category->products->count() }}</span></td></tr>
<tr><th>Status</th><td>@if($category->status)<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td></tr>
<tr><th>Created At</th><td>{{ $category->created_at->format('d M Y, h:i A') }}</td></tr>
</table></div>
<div class="card-footer"><a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
<a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></div>
</div></div></div>
@endsection
