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
