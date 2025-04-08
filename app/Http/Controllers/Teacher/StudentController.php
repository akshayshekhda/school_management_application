<?php

// app/Http/Controllers/Teacher/StudentController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();
        $query = $teacher->students();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->has('class') && $request->class !== 'all') {
            $query->where('class', $request->class);
        }

        // Sort functionality
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $allowedSortFields = ['name', 'email', 'class', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $students = $query->paginate(10)->withQueryString();
        $classes = $teacher->students()->distinct()->pluck('class')->filter()->values();

        return view('teacher.students.index', compact('students', 'classes'));
    }

    public function create()
    {
        return view('teacher.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'class' => 'required|string|max:50',
            'bio' => 'nullable|string|max:500',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        $teacher = Auth::guard('teacher')->user();
        $validated['teacher_id'] = $teacher->id;
        
        Student::create($validated);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        // Check if the student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.students.index')
                ->with('error', 'Unauthorized access.');
        }

        return view('teacher.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Check if the student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.students.index')
                ->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'class' => 'required|string|max:50',
            'bio' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Check if the student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        if ($student->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.students.index')
                ->with('error', 'Unauthorized access.');
        }

        $student->delete();

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}