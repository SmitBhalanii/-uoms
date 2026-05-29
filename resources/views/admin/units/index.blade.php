@extends('layouts.admin')
@section('page-title', 'Units')
@section('breadcrumb')
<li class="breadcrumb-item active">Units</li>
@endsection
@section('content')
<div class="row"><div class="col-12"><div class="card"><div class="card-header"><h3 class="card-title">Unit List</h3>
<div class="card-tools"><a href="{{ route('admin.units.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Unit</a></div></div>
<div class="card-body"><table class="table table-bordered table-striped"><thead><tr><th>ID</th><th>Unit Name</th><th>Short Name</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>@forelse($units as $unit)<tr><td>{{ $unit->id }}</td><td>{{ $unit->unit_name }}</td>
<td><span class="badge badge-info">{{ $unit->short_name }}</span></td>
<td>@if($unit->status)<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td>
<td><a href="{{ route('admin.units.show', $unit) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
<a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
<form action="{{ route('admin.units.destroy', $unit) }}" method="POST" style="display:inline-block;">@csrf @method('DELETE')
<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button></form></td></tr>
@empty<tr><td colspan="5" class="text-center">No units found.</td></tr>@endforelse</tbody></table></div>
<div class="card-footer clearfix">{{ $units->links() }}</div></div></div></div>
@endsection
