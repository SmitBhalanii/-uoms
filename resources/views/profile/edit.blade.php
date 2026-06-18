@extends('layouts.admin')

@section('page-title', 'Profile Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Profile Information
                    </h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Your email address</small>
                        </div>

                        @if(auth()->user()->role === 'user')
                            <div class="form-group">
                                <label for="college_name">College Name</label>
                                <input type="text" name="college_name" id="college_name" class="form-control @error('college_name') is-invalid @enderror" value="{{ old('college_name', auth()->user()->college_name) }}">
                                @error('college_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', auth()->user()->department) }}">
                                @error('department')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key"></i> Change Password
                    </h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="password_update" value="1">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="current_password">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Account Information
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 150px;">Role</th>
                                <td>
                                    <span class="badge badge-{{ auth()->user()->role === 'admin' ? 'danger' : 'primary' }}">
                                        {{ strtoupper(auth()->user()->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Account Status</th>
                                <td>
                                    @if(auth()->user()->is_active ?? true)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Member Since</th>
                                <td>{{ auth()->user()->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ auth()->user()->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
