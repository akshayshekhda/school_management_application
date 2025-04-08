<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentModel::with(['student.teacher'])->paginate(10);
        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        $students = Student::with('teacher')->get();
        return view('admin.parents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:parents',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'student_id' => 'required|exists:students,id'
        ]);

        $parent = ParentModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'occupation' => $request->occupation,
            'student_id' => $request->student_id
        ]);

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent created successfully');
    }

    public function edit(ParentModel $parent)
    {
        $students = Student::with('teacher')->get();
        return view('admin.parents.edit', compact('parent', 'students'));
    }

    public function update(Request $request, ParentModel $parent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('parents')->ignore($parent->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'student_id' => 'required|exists:students,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'occupation' => $request->occupation,
            'student_id' => $request->student_id
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $parent->update($data);

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent updated successfully');
    }

    public function destroy(ParentModel $parent)
    {
        $parent->delete();
        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent deleted successfully');
    }
}
