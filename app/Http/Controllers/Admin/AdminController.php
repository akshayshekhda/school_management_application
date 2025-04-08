<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get counts for dashboard stats
        $stats = [
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'parents' => ParentModel::count(),
            'announcements' => Announcement::count(),
        ];

        // Get recent activities
        $recentTeachers = Teacher::latest()->take(5)->get();
        $recentStudents = Student::latest()->take(5)->get();
        $recentAnnouncements = Announcement::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTeachers', 'recentStudents', 'recentAnnouncements'));
    }
}
