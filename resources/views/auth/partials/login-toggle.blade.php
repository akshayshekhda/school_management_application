<div class="login-toggle">
    <a href="{{ route('admin.login') }}" class="login-toggle-btn {{ request()->routeIs('admin.login') ? 'active' : '' }}">
        Admin Login
    </a>
    <a href="{{ route('teacher.login') }}" class="login-toggle-btn {{ request()->routeIs('teacher.login') ? 'active' : '' }}">
        Teacher Login
    </a>
</div>
