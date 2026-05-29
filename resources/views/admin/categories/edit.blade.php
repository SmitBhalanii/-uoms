@extends("layouts.admin")
@section("page-title", "Edit Category")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route("admin.categories.index") }}">Categories</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section("content")
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Edit Category</h3></div>
<form action="{{ route("admin.categories.update", $category) }}" method="POST">@csrf @method("PUT")
<div class="card-body">
<div class="form-group"><label for="category_name">Category Name <span class="text-danger">*</span></label>
<input type="text" name="category_name" id="category_name" class="form-control @error("category_name") is-invalid @enderror" value="{{ old("category_name", $category->category_name) }}" required>
@error("category_name")<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><label for="description">Description</label>
<textarea name="description" id="description" rows="3" class="form-control @error("description") is-invalid @enderror">{{ old("description", $category->description) }}</textarea>
@error("description")<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><div class="custom-control custom-switch">
<input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old("status", $category->status) ? "checked" : "" }}>
<label class="custom-control-label" for="status">Active</label></div></div></div>
<div class="card-footer"><a href="{{ route("admin.categories.index") }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
<button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Update Category</button></div>
</form></div></div></div>
@endsection
