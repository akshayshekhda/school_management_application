<!-- resources/views/teacher/announcements/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-dark">{{ __('Announcements') }}</h5>
                            <p class="text-muted small mb-0">Manage your announcements</p>
                        </div>
                        <a href="{{ route('teacher.announcements.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Create Announcement
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Title</th>
                                    <th class="border-0">Content</th>
                                    <th class="border-0">Target</th>
                                    <th class="border-0">Created At</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="fw-medium">{{ $announcement->title }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ Str::limit($announcement->content, 50) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @php
                                                $badgeClass = match($announcement->target) {
                                                    'students' => 'bg-success',
                                                    'parents' => 'bg-warning',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($announcement->target) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">
                                                {{ $announcement->created_at->format('M d, Y H:i') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-end">
                                            <a href="{{ route('teacher.announcements.edit', $announcement) }}" 
                                               class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('teacher.announcements.destroy', $announcement) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-bullhorn fa-2x mb-3"></i>
                                                <p class="mb-0">No announcements found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($announcements->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        {{ $announcements->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush
@endsection
