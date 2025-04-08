<?php

// app/Http/Controllers/Teacher/ParentController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        if(empty($teacher) || $teacher->students->isEmpty()) {
            return redirect()->route('teacher.students.index')
                ->with('error', 'No students assigned to this teacher');
        }
        $students = $teacher->students->pluck('id')->toArray();
        $parents = ParentModel::whereIn('student_id', $students)->paginate(10);
        return view('teacher.parents.index', compact('parents'));
    }

    public function create()
    {
        $teacher = Auth::guard('teacher')->user();
        $students = $teacher->students()->whereDoesntHave('parent')->get();
        
        if ($students->isEmpty()) {
            return redirect()->route('teacher.parents.index')
                ->with('error', 'All students already have parents assigned.');
        }

        return view('teacher.parents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:parents',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'student_id' => [
                'required',
                Rule::exists('students', 'id')->where(function ($query) {
                    $teacher = Auth::guard('teacher')->user();
                    $query->where('teacher_id', $teacher->id);
                }),
            ],
        ]);

        // Verify student belongs to teacher and doesn't have a parent
        $teacher = Auth::guard('teacher')->user();
        $student = $teacher->students()->findOrFail($request->student_id);
        
        if ($student->parent()->exists()) {
            return redirect()->route('teacher.parents.create')
                ->with('error', 'Selected student already has a parent.');
        }

        $parent = ParentModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'student_id' => $student->id,
        ]);

        return redirect()->route('teacher.parents.index')
            ->with('success', 'Parent created successfully.');
    }

    public function edit(ParentModel $parent)
    {
        // Check if the parent's student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        $studentIds = $teacher->students->pluck('id')->toArray();
        
        if (!in_array($parent->student_id, $studentIds)) {
            return redirect()->route('teacher.parents.index')
                ->with('error', 'Unauthorized access.');
        }

        $students = $teacher->students()
            ->where('id', $parent->student_id)
            ->orWhereDoesntHave('parent')
            ->get();

        return view('teacher.parents.edit', compact('parent', 'students'));
    }

    public function update(Request $request, ParentModel $parent)
    {
        // Check if the parent's student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        $studentIds = $teacher->students->pluck('id')->toArray();
        
        if (!in_array($parent->student_id, $studentIds)) {
            return redirect()->route('teacher.parents.index')
                ->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:parents,email,' . $parent->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'student_id' => [
                'required',
                Rule::exists('students', 'id')->where(function ($query) {
                    $teacher = Auth::guard('teacher')->user();
                    $query->where('teacher_id', $teacher->id);
                }),
            ],
        ]);

        $parent->name = $request->name;
        $parent->email = $request->email;
        $parent->phone = $request->phone;
        
        if ($request->filled('password')) {
            $parent->password = Hash::make($request->password);
        }

        // Only update student_id if it's different
        if ($parent->student_id != $request->student_id) {
            // Verify new student doesn't have a parent (except current parent)
            $hasParent = ParentModel::where('student_id', $request->student_id)
                ->where('id', '!=', $parent->id)
                ->exists();
            
            if ($hasParent) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected student already has a parent.');
            }
            
            $parent->student_id = $request->student_id;
        }

        $parent->save();

        return redirect()->route('teacher.parents.index')
            ->with('success', 'Parent updated successfully.');
    }

    public function destroy(ParentModel $parent)
    {
        // Check if the parent's student belongs to the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        $studentIds = $teacher->students->pluck('id')->toArray();
        
        if (!in_array($parent->student_id, $studentIds)) {
            return redirect()->route('teacher.parents.index')
                ->with('error', 'Unauthorized access.');
        }

        $parent->delete();

        return redirect()->route('teacher.parents.index')
            ->with('success', 'Parent deleted successfully.');
    }
}