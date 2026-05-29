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
                    <h3 class="card-title">Department Information</h3>
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
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
