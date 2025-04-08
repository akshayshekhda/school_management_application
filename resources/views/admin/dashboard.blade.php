<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Teachers</h5>
                                    <p class="card-text">{{ \App\Models\Teacher::count() }}</p>
                                    <a href="{{ route('admin.teachers.index') }}"
                                        class="btn btn-sm btn-light">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Students</h5>
                                    <p class="card-text">{{ \App\Models\Student::count() }}</p>
                                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-light">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Parents</h5>
                                    <p class="card-text">{{ \App\Models\ParentModel::count() }}</p>
                                    <a href="{{ route('admin.parents.index') }}" class="btn btn-sm btn-light">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Your Announcements</h5>
                                    <p class="card-text">
                                        {{ \App\Models\Announcement::where('created_by_type', 'App\Models\Admin')->count() }}
                                    </p>
                                    <a href="{{ route('admin.announcements.index') }}"
                                        class="btn btn-sm btn-dark">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Teacher Announcements</h5>
                                    <p class="card-text">
                                        {{ \App\Models\Announcement::where('created_by_type', 'App\Models\Teacher')->count() }}
                                    </p>
                                    <a href="{{ route('admin.announcements.index', ['type' => 'teacher']) }}"
                                        class="btn btn-sm btn-light">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection