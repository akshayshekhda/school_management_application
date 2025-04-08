<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    @stack('scripts')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="javascript:void(0)">
                    {{ config('app.name', 'School Management') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.teachers.index') }}">Teachers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.students.index') }}">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.parents.index') }}">Parents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.announcements.index') }}">Announcements</a>
                        </li>
                        @endif
                        @if(Auth::guard('teacher')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.students.index') }}">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.parents.index') }}">Parents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.announcements.index') }}">Announcements</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item dropdown">
                            <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endif

                        @if(Auth::guard('teacher')->check())
                        <li class="nav-item dropdown">
                            <a id="teacherDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('teacher')->user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teacherDropdown">
                                <a class="dropdown-item" href="{{ route('teacher.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('teacher-logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="teacher-logout-form" action="{{ route('teacher.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="container">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <style>
    .navbar {
        padding: 1rem 0;
        background: #ffffff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .navbar-brand {
        font-weight: 600;
        font-size: 1.25rem;
        color: #2d3748;
        padding: 0.5rem 0;
    }

    .navbar-toggler {
        padding: 0.75rem;
        font-size: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        transition: all 0.2s ease-in-out;
        margin-right: 0.5rem;
        position: relative;
        background: #ffffff;
    }

    .navbar-toggler:focus,
    .navbar-toggler:active {
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
    }

    .navbar-toggler:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(45, 55, 72, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        width: 1.5em;
        height: 1.5em;
        transition: transform 0.2s;
    }

    .navbar-collapse {
        transition: all 0.3s ease-in-out;
    }

    .navbar-nav .nav-link {
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: #4a5568;
        border-radius: 0.375rem;
        transition: all 0.2s;
        margin: 0.125rem 0;
    }

    .navbar-nav .nav-link:hover {
        color: #2d3748;
        background-color: #f7fafc;
    }

    .navbar-nav .nav-link.active {
        color: #4c51bf;
        background-color: #ebf4ff;
    }

    .navbar-nav .nav-item.dropdown {
        position: relative;
    }

    .navbar-nav .nav-item.dropdown .dropdown-menu {
        padding: 0.5rem 0;
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-top: 0.5rem;
        background: #ffffff;
        min-width: 12rem;
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        color: #4a5568;
        transition: all 0.2s;
        font-size: 0.875rem;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        color: #2d3748;
        background-color: #f7fafc;
        text-decoration: none;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }

        .navbar-nav {
            padding: 0.5rem 0;
        }

        .navbar-nav .nav-link {
            padding: 0.875rem 1.25rem;
            border-radius: 0.375rem;
        }

        .navbar-nav .nav-item.dropdown .dropdown-menu {
            box-shadow: none;
            padding: 0.5rem 0;
            margin: 0;
            background-color: #f8fafc;
            border-radius: 0.375rem;
        }

        .dropdown-item {
            padding: 0.875rem 1.5rem;
        }

        .navbar-collapse.show,
        .navbar-collapse.collapsing {
            animation: slideDown 0.3s ease-out;
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Styles */
    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, .05);
    }

    /* Form Styles */
    .form-control,
    .form-select {
        border-radius: 0.375rem;
        padding: 0.625rem 0.875rem;
        border-color: #e5e7eb;
        font-size: 0.875rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
    }

    /* Button Styles */
    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    .btn-outline-primary {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .btn-outline-primary:hover {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    /* Table Styles */
    .table {
        font-size: 0.875rem;
    }

    .table th {
        font-weight: 600;
        color: #4b5563;
        background-color: #f9fafb;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .table td {
        vertical-align: middle;
        color: #374151;
    }

    /* Badge Styles */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }

    /* Form Check */
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    /* Alerts */
    .alert {
        border: none;
        border-radius: 0.375rem;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
    }

    .alert-danger {
        background-color: #fef2f2;
        color: #991b1b;
    }

    /* Utilities */
    .text-muted {
        color: #6b7280 !important;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    .fw-medium {
        font-weight: 500 !important;
    }
    </style>
</body>

</html>