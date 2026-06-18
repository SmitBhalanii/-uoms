@extends('layouts.admin')

@section('page-title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
    <div class="row">
        <!-- Profile Settings -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i> Update Profile
                    </h3>
                </div>
                <form action="{{ route('admin.settings.profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
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
                                    <span class="badge badge-danger">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Account Status</th>
                                <td>
                                    @if($user->is_active ?? true)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Member Since</th>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key"></i> Change Password
                    </h3>
                </div>
                <form action="{{ route('admin.settings.password') }}" method="POST">
                    @csrf
                    @method('PUT')
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
                            <label for="password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i> System Information
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 150px;">Application</th>
                                <td>UOMS v1.0.0</td>
                            </tr>
                            <tr>
                                <th>Laravel Version</th>
                                <td>{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <th>PHP Version</th>
                                <td>{{ PHP_VERSION }}</td>
                            </tr>
                            <tr>
                                <th>Environment</th>
                                <td>
                                    <span class="badge badge-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                                        {{ strtoupper(app()->environment()) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
