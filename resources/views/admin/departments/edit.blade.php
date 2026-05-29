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
                        <div class="form-group">
                            <label for="department_name">Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="department_name" id="department_name" 
                                   class="form-control @error('department_name') is-invalid @enderror" 
                                   value="{{ old('department_name', $department->department_name) }}" required>
                            @error('department_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lab_code">Lab Code <span class="text-danger">*</span></label>
                            <input type="text" name="lab_code" id="lab_code" 
                                   class="form-control @error('lab_code') is-invalid @enderror" 
                                   value="{{ old('lab_code', $department->lab_code) }}" required>
                            @error('lab_code')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hod_name">HOD Name</label>
                            <input type="text" name="hod_name" id="hod_name" 
                                   class="form-control @error('hod_name') is-invalid @enderror" 
                                   value="{{ old('hod_name', $department->hod_name) }}">
                            @error('hod_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" 
                                       {{ old('status', $department->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-save"></i> Update Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
