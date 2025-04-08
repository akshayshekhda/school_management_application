<?php

// app/Http/Controllers/Admin/AnnouncementController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendAnnouncementEmail;
use App\Mail\AnnouncementMail;
use App\Models\Announcement;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();
        
        // Filter by type if specified
        if ($request->type === 'teacher') {
            $query->where('created_by_type', 'App\Models\Teacher');
        } else {
            $query->where('created_by_type', 'App\Models\Admin');
        }
        
        $announcements = $query->with('created_by')->latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:teachers,students,parents,all',
            'send_email' => 'nullable|boolean'
        ]);

        $admin = Auth::guard('admin')->user();
        
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'target' => $request->target,
            'created_by_id' => $admin->id,
            'created_by_type' => 'App\Models\Admin',
        ]);

        // Send emails if requested
        if ($request->send_email) {
            try {
                $recipients = [];
                
                if ($request->target === 'teachers' || $request->target === 'all') {
                    $teachers = Teacher::all();
                    foreach ($teachers as $teacher) {
                        $recipients[] = $teacher->email;
                    }
                }
                
                if ($request->target === 'students' || $request->target === 'all') {
                    $students = Student::all();
                    foreach ($students as $student) {
                        $recipients[] = $student->email;
                    }
                }
                
                if ($request->target === 'parents' || $request->target === 'all') {
                    $parents = ParentModel::all();
                    foreach ($parents as $parent) {
                        $recipients[] = $parent->email;
                    }
                }

                Log::info('Queueing announcement emails', [
                    'announcement_id' => $announcement->id,
                    'recipient_count' => count($recipients)
                ]);

                // Queue emails for sending in the background
                foreach ($recipients as $email) {
                    SendAnnouncementEmail::dispatch($announcement, $email)->onQueue('emails');
                }

                return redirect()->route('admin.announcements.index')
                    ->with('success', 'Announcement created successfully and emails have been queued for sending');

            } catch (Exception $e) {
                Log::error('Error in announcement email process', [
                    'error' => $e->getMessage(),
                    'announcement_id' => $announcement->id
                ]);

                return redirect()->route('admin.announcements.index')
                    ->with('warning', 'Announcement created but there was an issue queuing emails. Please check the logs.');
            }
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    public function edit(Announcement $announcement)
    {
        if ($announcement->created_by_type !== 'App\Models\Admin') {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'You can only edit admin announcements');
        }
        
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->created_by_type !== 'App\Models\Admin') {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'You can only edit admin announcements');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->created_by_type !== 'App\Models\Admin') {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'You can only delete admin announcements');
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}