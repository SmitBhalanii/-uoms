@extends('layouts.admin')

@section('page-title', 'User Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">User Details</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">User ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>College Name</th>
                                <td>{{ $user->college_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ $user->department ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($user->is_active ?? true)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Bill To Address</th>
                                <td>{{ $user->bill_to_address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Ship To Address</th>
                                <td>{{ $user->ship_to_address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Registered At</th>
                                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Statistics</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Total Orders</th>
                                <td><span class="badge badge-primary">{{ $user->orders->count() }}</span></td>
                            </tr>
                            <tr>
                                <th>Pending Orders</th>
                                <td><span class="badge badge-warning">{{ $user->orders->where('status', 'pending')->count() }}</span></td>
                            </tr>
                            <tr>
                                <th>Approved Orders</th>
                                <td><span class="badge" style="background-color: #3498db; color: white;">{{ $user->orders->where('status', 'approved')->count() }}</span></td>
                            </tr>
                            <tr>
                                <th>Wishlist Items</th>
                                <td><span class="badge badge-info">{{ $user->wishlists->count() }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <div class="card-body">
                    @if($user->orders->count() > 0)
                        <ul class="list-group">
                            @foreach($user->orders->take(5) as $order)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Order #{{ $order->order_number }}</strong><br>
                                        <small>{{ $order->created_at->format('d M Y') }}</small>
                                    </div>
                                    <span class="badge badge-{{ $order->status === 'approved' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
