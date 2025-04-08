@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-graduate me-2"></i>{{ __('Students') }}
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>{{ __('Add New Student') }}
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.students.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Search Box -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-semibold">Search</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" name="search"
                                value="{{ request('search') }}" placeholder="Search students...">
                        </div>
                        <div class="form-text">Search by name, email, phone or class</div>
                    </div>

                    <!-- Class Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-semibold">Class</label>
                        <select name="class" class="form-select">
                            <option value="all">All Classes</option>

                        </select>
                        <div class="form-text">Filter by class</div>
                    </div>

                    <!-- Sort Options -->
                    <div class="col-lg-3 col-md-8">
                        <label class="form-label text-muted small text-uppercase fw-semibold">Sort By</label>
                        <div class="input-group">
                            <select name="sort" class="form-select border-end-0 rounded-end-0">
                                <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Name
                                </option>
                                <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="class" {{ request('sort') == 'class' ? 'selected' : '' }}>Class</option>
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date
                                    Added</option>
                            </select>
                            <select name="direction" class="form-select border-start-0 rounded-start-0"
                                style="max-width: 100px;">
                                <option value="asc" {{ request('direction', 'asc') == 'asc' ? 'selected' : '' }}>ASC
                                </option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>DESC
                                </option>
                            </select>
                        </div>
                        <div class="form-text">Choose sorting order</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            @if(request()->hasAny(['search', 'class', 'sort', 'direction']))
                            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary"
                                data-bs-toggle="tooltip" title="Clear filters">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="60">#</th>
                            <th>
                                <i class="fas fa-user me-2 text-muted"></i>Name
                            </th>
                            <th>
                                <i class="fas fa-envelope me-2 text-muted"></i>Email
                            </th>
                            <th>
                                <i class="fas fa-graduation-cap me-2 text-muted"></i>Class
                            </th>
                            <th>Created By</th>
                            <th class="text-end pe-4" width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)

                        <tr>
                            <td class="align-middle ps-4">{{ $loop->iteration }}</td>
                            <td class="align-middle d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $student->name }}</div>
                                        <div class="text-muted small">Roll No: {{ $student->roll_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">{{ $student->email }}</td>
                            <td class="align-middle">
                                @if($student->class)
                                <span class="badge bg-info-subtle text-info">
                                    {{ $student->class }}
                                </span>
                                @else
                                -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($student->teacher)
                                <span class="badge bg-info">{{ $student->teacher->name }}</span>
                                @else
                                <span class="badge bg-secondary">Admin</span>
                                @endif
                            </td>
                            <td class="align-middle text-end pe-4">
                                <a href="{{ route('admin.students.edit', $student->id) }}"
                                    class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $student->id }}">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center pb-0">
                                                <div class="mb-4">
                                                    <span class="avatar-circle bg-danger-subtle mb-3"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                                    </span>
                                                    <h5 class="modal-title mb-2">Delete Student</h5>
                                                    <p class="text-muted mb-0">
                                                        Are you sure you want to delete student
                                                        <strong>{{ $student->name }}</strong>?<br>
                                                        This action cannot be undone.
                                                    </p>
                                                </div>
                                                <div class="d-flex gap-2 justify-content-center mb-4">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancel
                                                    </button>
                                                    <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt me-2"></i>Delete Student
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <div class="py-3">
                                    <i class="fas fa-user-graduate fa-2x mb-3"></i>
                                    <p class="mb-0 fw-medium">No students found</p>
                                    @if(request()->hasAny(['search', 'class', 'sort', 'direction']))
                                    <p class="mb-0 small text-muted">Try adjusting your search or filter criteria</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination mb-0">
                {{-- Previous Page Link --}}
                @if ($students->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-chevron-left small"></i>
                    </span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $students->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left small"></i>
                    </a>
                </li>
                @endif

                {{-- Next Page Link --}}
                @if ($students->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $students->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right small"></i>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-chevron-right small"></i>
                    </span>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

<style>
.card {
    border: none;
    border-radius: 0.5rem;
}

.table> :not(caption)>*>* {
    padding: 1rem 0.75rem;
    border-bottom-color: #f1f4f8;
}

.table>thead>tr>th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    color: #6c757d;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f4f8;
}

.avatar-circle {
    width: 36px;
    height: 36px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
    font-size: 0.75rem;
}

.bg-info-subtle {
    background-color: #e1f5fe;
}

.text-info {
    color: #0288d1 !important;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.875rem;
}

.btn-outline-primary {
    border-color: #dee2e6;
    color: #0d6efd;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

.btn-outline-danger {
    border-color: #dee2e6;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

/* Search and Filter Styles */
.form-label {
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.input-group-text {
    background-color: #fff;
    border-color: #dee2e6;
}

.form-control,
.form-select {
    border-color: #dee2e6;
    padding: 0.6rem 1rem;
    font-size: 0.875rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.form-text {
    color: #6c757d;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-control::placeholder {
    color: #adb5bd;
    font-size: 0.875rem;
}

/* Filter Button Styles */
.btn {
    padding: 0.6rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.01em;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    padding: 1rem 1rem 0;
}

.modal-body {
    padding: 1.5rem;
}

.btn-close {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 1;
}

.bg-danger-subtle {
    background-color: #fee2e2;
}

.text-danger {
    color: #dc3545 !important;
}

.avatar-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
}

.avatar-circle i {
    font-size: 1.25rem;
}

/* Pagination Styles */
.pagination {
    gap: 0.25rem;
}

.page-link {
    border: none;
    padding: 0.5rem 0.75rem;
    color: #6c757d;
    border-radius: 0.375rem;
    min-width: 32px;
    text-align: center;
}

.page-link:hover {
    background-color: #e9ecef;
    color: #0d6efd;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    color: #fff;
}

.page-item.disabled .page-link {
    background-color: transparent;
    color: #adb5bd;
}

@media (max-width: 768px) {
    .table-responsive {
        border-radius: 0.5rem;
    }

    .form-label {
        margin-bottom: 0.25rem;
    }

    .col-md-4.d-flex {
        margin-top: 1rem;
    }
}
</style>
@endsection