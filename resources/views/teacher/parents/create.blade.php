<!-- resources/views/teacher/parents/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-dark">{{ __('Add New Parent') }}</h5>
                            <p class="text-muted small mb-0">Create a new parent account</p>
                        </div>
                        <a href="{{ route('teacher.parents.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.parents.store') }}">
                        @csrf

                        <div class="form-group row mb-4">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus
                                    placeholder="Enter parent's full name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="email" class="col-md-3 col-form-label">{{ __('Email') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required
                                    placeholder="Enter parent's email address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="phone" class="col-md-3 col-form-label">{{ __('Phone') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required
                                    placeholder="Enter parent's phone number">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-3 col-form-label">{{ __('Password') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required placeholder="Enter password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-3 col-form-label">{{ __('Confirm Password') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="Confirm password">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="student_id" class="col-md-3 col-form-label">{{ __('Student') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select id="student_id" class="form-select @error('student_id') is-invalid @enderror"
                                    name="student_id" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->roll_number }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> {{ __('Create Parent') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
