@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="page-header mb-4">
    <h1 class="h3">
        <i class="fas fa-edit text-primary"></i> Edit Category
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}">Categories</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Form Section -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-folder"></i> Category Information
                </h5>
            </div>

            <div class="card-body">
                <form method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Category Name -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter category name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Description
                        </label>
                        <textarea name="description"
                                  rows="5"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Optional category description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center border rounded p-3">
                            <div>
                                <h6 class="mb-1">Category Status</h6>
                                <small class="text-muted">
                                    Enable to show this category in POS
                                </small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb"></i> Best Practices
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Keep category names simple
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Disable instead of deleting
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Use clear descriptions
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
