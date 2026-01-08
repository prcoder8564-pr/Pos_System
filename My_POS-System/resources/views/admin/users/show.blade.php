@extends('layouts.admin')

@section('title', 'User Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">User Profile</h2>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.users.change-password-form', $user) }}" class="btn btn-secondary">
            <i class="fas fa-key"></i> Change Password
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <!-- User Info Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 120px; height: 120px; font-size: 48px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="mb-3">
                    <span class="badge bg-{{ $user->role_badge }} fs-6">
                        <i class="fas fa-{{ $user->role == 'admin' ? 'user-shield' : ($user->role == 'manager' ? 'user-tie' : 'user') }}"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    
                    @if($user->status == 'active')
                        <span class="badge bg-success fs-6">Active</span>
                    @else
                        <span class="badge bg-secondary fs-6">Inactive</span>
                    @endif
                    
                    @if($user->id == auth()->id())
                        <span class="badge bg-primary fs-6">You</span>
                    @endif
                </div>
                
                <div class="text-start">
                    <hr>
                    <div class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        {{ $user->phone ?: 'No phone number' }}
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-calendar text-muted me-2"></i>
                        Joined {{ $user->created_at->format('d M Y') }}
                    </div>
                    <div>
                        <i class="fas fa-clock text-muted me-2"></i>
                        Last update {{ $user->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Activity Stats</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Sales Created:</span>
                    <strong>{{ $user->sales_count ?? 0 }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Purchases Created:</span>
                    <strong>{{ $user->purchases_count ?? 0 }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details & Permissions -->
    <div class="col-md-8">
        <!-- User Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">User Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Full Name:</label>
                        <p><strong>{{ $user->name }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Email Address:</label>
                        <p><strong>{{ $user->email }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Phone Number:</label>
                        <p><strong>{{ $user->phone ?: 'Not provided' }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Role:</label>
                        <p>
                            <span class="badge bg-{{ $user->role_badge }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Status:</label>
                        <p>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Member Since:</label>
                        <p><strong>{{ $user->created_at->format('d M Y, h:i A') }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Role Permissions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Permissions</h5>
            </div>
            <div class="card-body">
                @if($user->role == 'admin')
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-user-shield"></i> Administrator - Full Access</h6>
                        <ul class="mb-0">
                            <li>✅ Create, Edit, Delete all records</li>
                            <li>✅ Manage users and roles</li>
                            <li>✅ View all reports and analytics</li>
                            <li>✅ Access system settings</li>
                            <li>✅ Complete access to POS</li>
                            <li>✅ Manage inventory, purchases, and sales</li>
                        </ul>
                    </div>
                @elseif($user->role == 'manager')
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-user-tie"></i> Manager - Limited Access</h6>
                        <ul class="mb-0">
                            <li>✅ Create and Edit records</li>
                            <li>✅ View all reports and analytics</li>
                            <li>✅ Access POS system</li>
                            <li>✅ Manage inventory and purchases</li>
                            <li>❌ Cannot delete records</li>
                            <li>❌ Cannot manage users</li>
                            <li>❌ Cannot access system settings</li>
                        </ul>
                    </div>
                @else
                    <div class="alert alert-info">
                        <h6><i class="fas fa-user"></i> Cashier - POS Only</h6>
                        <ul class="mb-0">
                            <li>✅ Access POS/Sales system</li>
                            <li>✅ Create sales transactions</li>
                            <li>✅ View product information</li>
                            <li>❌ Cannot access admin panel</li>
                            <li>❌ Cannot view reports</li>
                            <li>❌ Cannot manage inventory</li>
                            <li>❌ Cannot access settings</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection