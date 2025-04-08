<!-- resources/views/teacher/announcements/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-dark">{{ __('Create Announcement') }}</h5>
                            <p class="text-muted small mb-0">Create a new announcement for your students and their parents</p>
                        </div>
                        <a href="{{ route('teacher.announcements.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.announcements.store') }}">
                        @csrf

                        <div class="form-group row mb-4">
                            <label for="title" class="col-md-3 col-form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="title" 
                                       type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       required 
                                       autofocus
                                       placeholder="Enter announcement title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="content" class="col-md-3 col-form-label">{{ __('Content') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea id="content" 
                                          class="form-control @error('content') is-invalid @enderror" 
                                          name="content" 
                                          rows="6" 
                                          required
                                          placeholder="Enter announcement content">{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="target" class="col-md-3 col-form-label">{{ __('Target Audience') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select id="target" 
                                        class="form-select @error('target') is-invalid @enderror" 
                                        name="target" 
                                        required>
                                    <option value="">Select Target Audience</option>
                                    <option value="students" {{ old('target') === 'students' ? 'selected' : '' }}>
                                        <i class="fas fa-user-graduate"></i> Students Only
                                    </option>
                                    <option value="parents" {{ old('target') === 'parents' ? 'selected' : '' }}>
                                        <i class="fas fa-user-friends"></i> Parents Only
                                    </option>
                                    <option value="both" {{ old('target') === 'both' ? 'selected' : '' }}>
                                        <i class="fas fa-users"></i> Both Students and Parents
                                    </option>
                                </select>
                                @error('target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-md-9 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="send_email" 
                                           id="send_email" 
                                           value="1" 
                                           {{ old('send_email') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="send_email">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ __('Send Email Notification') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> {{ __('Create Announcement') }}
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
