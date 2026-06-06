@extends('layouts.admin')

@section('page-title', 'Departments')

@section('breadcrumb')
    <li class="breadcrumb-item active">Departments</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Department List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Department
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Sr No</th>
                                <th>Department Name</th>
                                <th>Lab Code</th>
                                <th>HOD Name</th>
                                <th>Status</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                                <tr>
                                    <td>{{ ($departments->currentPage() - 1) * $departments->perPage() + $loop->iteration }}</td>
                                    <td>{{ $department->department_name }}</td>
                                    <td><span class="badge badge-info">{{ $department->lab_code }}</span></td>
                                    <td>{{ $department->hod_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($department->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.departments.show', $department) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" style="display:inline-block;">
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
                                    <td colspan="6" class="text-center">No departments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
