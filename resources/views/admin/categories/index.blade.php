@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-tags"></i> Categories</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Category
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $categories->total() }}</h3>
                    <p>Total Categories</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stats-card success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $categories->where('is_active', true)->count() }}</h3>
                    <p>Active Categories</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $categories->where('is_active', false)->count() }}</h3>
                    <p>Inactive Categories</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="custom-table">
    <div class="p-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">All Categories</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <input type="text" class="form-control" placeholder="Search categories..." 
                           style="max-width: 300px;" id="searchInput">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0" id="categoriesTable">
            <thead>
                <tr>
                    <th width="80">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th width="180" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $categories->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $category->name }}</strong>
                    </td>
                    <td>
                        <span class="text-muted">
                            {{ $category->description ? Str::limit($category->description, 50) : 'No description' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $category->products_count }} Products
                        </span>
                    </td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-times"></i> Inactive
                            </span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('d M, Y') }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.categories.show', $category->id) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="deleteCategory({{ $category->id }})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No categories found</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Category
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="p-3 border-top">
        {{ $categories->links() }}
    </div>
    @endif
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#categoriesTable tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Delete category function
    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/categories/' + id;
            form.submit();
        }
    }
</script>
@endpush