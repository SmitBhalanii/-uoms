# Create all missing views for UOMS project

# Units Create
@'
@extends('layouts.admin')
@section('page-title', 'Add Unit')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Add</li>
@endsection
@section('content')
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Add New Unit</h3></div>
<form action="{{ route('admin.units.store') }}" method="POST">@csrf
<div class="card-body">
<div class="form-group"><label for="unit_name">Unit Name <span class="text-danger">*</span></label>
<input type="text" name="unit_name" id="unit_name" class="form-control @error('unit_name') is-invalid @enderror" value="{{ old('unit_name') }}" required>
@error('unit_name')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><label for="short_name">Short Name <span class="text-danger">*</span></label>
<input type="text" name="short_name" id="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name') }}" required>
@error('short_name')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><label for="description">Description</label>
<textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
@error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><div class="custom-control custom-switch">
<input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
<label class="custom-control-label" for="status">Active</label></div></div></div>
<div class="card-footer"><a href="{{ route('admin.units.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
<button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Save Unit</button></div>
</form></div></div></div>
@endsection
'@ | Out-File -FilePath "resources\views\admin\units\create.blade.php" -Encoding UTF8

Write-Host "Created units/create.blade.php"

# Units Edit
@'
@extends('layouts.admin')
@section('page-title', 'Edit Unit')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Edit Unit</h3></div>
<form action="{{ route('admin.units.update', $unit) }}" method="POST">@csrf @method('PUT')
<div class="card-body">
<div class="form-group"><label for="unit_name">Unit Name <span class="text-danger">*</span></label>
<input type="text" name="unit_name" id="unit_name" class="form-control @error('unit_name') is-invalid @enderror" value="{{ old('unit_name', $unit->unit_name) }}" required>
@error('unit_name')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><label for="short_name">Short Name <span class="text-danger">*</span></label>
<input type="text" name="short_name" id="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name', $unit->short_name) }}" required>
@error('short_name')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><label for="description">Description</label>
<textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $unit->description) }}</textarea>
@error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
<div class="form-group"><div class="custom-control custom-switch">
<input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $unit->status) ? 'checked' : '' }}>
<label class="custom-control-label" for="status">Active</label></div></div></div>
<div class="card-footer"><a href="{{ route('admin.units.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
<button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Update Unit</button></div>
</form></div></div></div>
@endsection
'@ | Out-File -FilePath "resources\views\admin\units\edit.blade.php" -Encoding UTF8

Write-Host "Created units/edit.blade.php"

# Units Show
@'
@extends('layouts.admin')
@section('page-title', 'Unit Details')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Details</li>
@endsection
@section('content')
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Unit Information</h3></div>
<div class="card-body"><table class="table table-bordered">
<tr><th width="200">Unit Name</th><td>{{ $unit->unit_name }}</td></tr>
<tr><th>Short Name</th><td><span class="badge badge-info">{{ $unit->short_name }}</span></td></tr>
<tr><th>Description</th><td>{{ $unit->description ?? 'N/A' }}</td></tr>
<tr><th>Status</th><td>@if($unit->status)<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td></tr>
<tr><th>Created At</th><td>{{ $unit->created_at->format('d M Y, h:i A') }}</td></tr>
</table></div>
<div class="card-footer"><a href="{{ route('admin.units.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
<a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a></div>
</div></div></div>
@endsection
'@ | Out-File -FilePath "resources\views\admin\units\show.blade.php" -Encoding UTF8

Write-Host "Created units/show.blade.php"
Write-Host "All unit views created successfully!"
