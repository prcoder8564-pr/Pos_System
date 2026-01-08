@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Change Password</h2>
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Profile
    </a>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-key"></i> Change Password for {{ $user->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Important:</strong> Changing the password will require the user to login again with the new password.
                </div>
                
                <form action="{{ route('admin.users.change-password', $user) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required autofocus>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 characters required</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mb-3">
                        <label class="form-label">Password Strength:</label>
                        <div class="progress" style="height: 10px;">
                            <div id="password-strength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="password-strength-text" class="text-muted"></small>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Password Requirements:</strong>
                        <ul class="mb-0">
                            <li>At least 8 characters long</li>
                            <li>Mix of uppercase and lowercase letters (recommended)</li>
                            <li>Include numbers (recommended)</li>
                            <li>Include special characters (recommended)</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('password-strength');
    const strengthText = document.getElementById('password-strength-text');
    
    let strength = 0;
    let text = '';
    let color = '';
    
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 25;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 25;
    
    if (strength === 0) {
        text = 'Very Weak';
        color = 'bg-danger';
    } else if (strength === 25) {
        text = 'Weak';
        color = 'bg-danger';
    } else if (strength === 50) {
        text = 'Fair';
        color = 'bg-warning';
    } else if (strength === 75) {
        text = 'Good';
        color = 'bg-info';
    } else if (strength === 100) {
        text = 'Strong';
        color = 'bg-success';
    }
    
    strengthBar.style.width = strength + '%';
    strengthBar.className = 'progress-bar ' + color;
    strengthText.textContent = text;
});
</script>
@endsection