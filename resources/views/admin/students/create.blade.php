@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-user-graduate me-2"></i>Add New Student
                        </h5>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.students.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted small text-uppercase fw-semibold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input id="name" type="text" 
                                       class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter student's full name</div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small text-uppercase fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input id="email" type="email" 
                                       class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This will be used for login</div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-muted small text-uppercase fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input id="password" type="password" 
                                       class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                       name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 8 characters</div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label text-muted small text-uppercase fw-semibold">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input id="phone" type="text" 
                                       class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional contact number</div>
                        </div>

                        <!-- Class -->
                        <div class="mb-3">
                            <label for="class" class="form-label text-muted small text-uppercase fw-semibold">Class</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-graduation-cap text-muted"></i>
                                </span>
                                <input id="class" type="text" 
                                       class="form-control border-start-0 ps-0 @error('class') is-invalid @enderror" 
                                       name="class" value="{{ old('class') }}" required>
                            </div>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Student's current class</div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-4">
                            <label for="bio" class="form-label text-muted small text-uppercase fw-semibold">Bio</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-info-circle text-muted"></i>
                                </span>
                                <textarea id="bio" 
                                          class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" 
                                          name="bio" rows="3">{{ old('bio') }}</textarea>
                            </div>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">A brief description about the student (optional)</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 0.5rem;
}

.card-header {
    border-bottom: 1px solid #f1f4f8;
    background-color: #fff;
}

.form-label {
    margin-bottom: 0.5rem;
}

.input-group-text {
    background-color: #fff;
    border-color: #dee2e6;
}

.form-control {
    border-color: #dee2e6;
    padding: 0.6rem 1rem;
}

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.form-text {
    color: #6c757d;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.btn-primary {
    padding: 0.6rem 1rem;
    font-weight: 500;
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
</style>
@endsection
