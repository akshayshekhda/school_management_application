<!-- resources/views/teacher/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Teacher Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Your Students</h5>
                                    <p class="card-text">{{ Auth::guard('teacher')->user()->students->count() }}</p>
                                    <a href="{{ route('teacher.students.index') }}" class="btn btn-sm btn-light">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Parents</h5>
                                    <p class="card-text">{{ Auth::guard('teacher')->user()->students->map->parent->count() }}</p>
                                    <a href="{{ route('teacher.parents.index') }}" class="btn btn-sm btn-light">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Your Announcements</h5>
                                    <p class="card-text">{{ Auth::guard('teacher')->user()->announcements->count() }}</p>
                                    <a href="{{ route('teacher.announcements.index') }}" class="btn btn-sm btn-light">Manage</a>
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
