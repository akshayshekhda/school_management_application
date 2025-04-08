<!-- resources/views/admin/teachers/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>{{ __('Add New Teacher') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.teachers.store') }}">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="section-header mb-4">
                            <h5 class="text-secondary"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-3 col-form-label">
                                <i class="fas fa-user me-2"></i>{{ __('Name') }}
                            </label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Enter full name">
                                <small class="form-text text-muted">Enter the teacher's full name as it should appear in school records.</small>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-3 col-form-label">
                                <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                            </label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Enter email address">
                                <small class="form-text text-muted">This email will be used for login and communications.</small>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="section-header mb-4 mt-5">
                            <h5 class="text-secondary"><i class="fas fa-shield-alt me-2"></i>Security</h5>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-3 col-form-label">
                                <i class="fas fa-lock me-2"></i>{{ __('Password') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="new-password"
                                        placeholder="Enter password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-3 col-form-label">
                                <i class="fas fa-lock me-2"></i>{{ __('Confirm Password') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control" 
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Professional Information -->
                        <div class="section-header mb-4 mt-5">
                            <h5 class="text-secondary"><i class="fas fa-id-card me-2"></i>Contact & Professional Info</h5>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-3 col-form-label">
                                <i class="fas fa-phone me-2"></i>{{ __('Phone') }}
                            </label>
                            <div class="col-md-9">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ old('phone') }}" required
                                    placeholder="Enter phone number">
                                <small class="form-text text-muted">Include country code if applicable (e.g., +1 234 567 8900).</small>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="subject" class="col-md-3 col-form-label">
                                <i class="fas fa-book me-2"></i>{{ __('Subject') }}
                            </label>
                            <div class="col-md-9">
                                <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" 
                                    name="subject" value="{{ old('subject') }}" required
                                    placeholder="Enter teaching subject">
                                <small class="form-text text-muted">Main subject or area of expertise.</small>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="bio" class="col-md-3 col-form-label">
                                <i class="fas fa-user-circle me-2"></i>{{ __('Bio') }}
                            </label>
                            <div class="col-md-9">
                                <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" 
                                    name="bio" rows="4" maxlength="500"
                                    placeholder="Enter professional biography">{{ old('bio') }}</textarea>
                                <small class="form-text text-muted">
                                    Brief professional background and teaching philosophy.
                                    <span id="bio-counter" class="float-end">0/500 characters</span>
                                </small>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>{{ __('Add Teacher') }}
                                </button>
                                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                                </a>
                            </div>
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
    border-bottom: none;
    border-radius: 0.5rem 0.5rem 0 0 !important;
    padding: 1rem 1.5rem;
}

.section-header {
    border-bottom: 2px solid #eee;
    padding-bottom: 0.5rem;
}

.section-header h5 {
    margin: 0;
    font-weight: 500;
}

.form-control {
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
}

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-text {
    margin-top: 0.25rem;
    font-size: 0.875rem;
}

.col-form-label {
    font-weight: 500;
    color: #344767;
}

.invalid-feedback {
    font-size: 0.875rem;
}

.btn {
    padding: 0.5rem 1rem;
    font-weight: 500;
    border-radius: 0.375rem;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

.input-group .btn-outline-secondary {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password-confirm');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');

    function updateCharacterCount() {
        const currentLength = bioTextarea.value.length;
        bioCounter.textContent = `${currentLength}/500 characters`;
    }

    bioTextarea.addEventListener('input', updateCharacterCount);
    updateCharacterCount(); // Initial count
});
</script>
@endpush
@endsection