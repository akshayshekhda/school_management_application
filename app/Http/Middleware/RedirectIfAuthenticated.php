<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // If no guards specified, check all guards
        $guards = empty($guards) ? ['admin', 'teacher'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Check if trying to access login routes
                if ($request->is('admin/login') || $request->is('admin')) {
                    return redirect()->route('admin.dashboard');
                }
                if ($request->is('teacher/login') || $request->is('teacher')) {
                    return redirect()->route('teacher.dashboard');
                }

                // For other routes, redirect based on guard
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                if ($guard === 'teacher') {
                    return redirect()->route('teacher.dashboard');
                }
            }
        }

        return $next($request);
    }
}
