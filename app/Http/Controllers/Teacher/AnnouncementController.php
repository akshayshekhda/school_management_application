<?php

// app/Http/Controllers/Teacher/AnnouncementController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Jobs\SendAnnouncementEmail;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();
        $announcements = $teacher->announcements()->latest()->paginate(10);
        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('teacher.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:students,parents,both',
            'send_email' => 'nullable|boolean'
        ]);

        $teacher = Auth::guard('teacher')->user();
        
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            // both means students and parents all 
            // all means all students and parents
            'target' => $request->target === 'both' ? 'all' : $request->target,
            'created_by_id' => $teacher->id,
            'created_by_type' => 'App\Models\Teacher',
        ]);

        // Send emails if requested
        if ($request->send_email) {
            try {
                $recipients = [];
                
                if ($request->target === 'students' || $request->target === 'both') {
                    Log::info('Fetching student recipients for teacher announcement', [
                        'teacher_id' => $teacher->id,
                        'announcement_id' => $announcement->id
                    ]);

                    $students = Student::whereHas('teacher', function($query) use ($teacher) {
                        $query->where('id', $teacher->id);
                    })->get();

                    Log::info('Found students', [
                        'count' => $students->count(),
                        'teacher_id' => $teacher->id
                    ]);

                    foreach ($students as $student) {
                        if ($student->email) {
                            $recipients[] = $student->email;
                        }
                    }
                }
                
                if ($request->target === 'parents' || $request->target === 'both') {
                    Log::info('Fetching parent recipients for teacher announcement', [
                        'teacher_id' => $teacher->id,
                        'announcement_id' => $announcement->id
                    ]);

                    $parents = ParentModel::whereHas('student.teacher', function($query) use ($teacher) {
                        $query->where('id', $teacher->id);
                    })->get();

                    Log::info('Found parents', [
                        'count' => $parents->count(),
                        'teacher_id' => $teacher->id
                    ]);

                    foreach ($parents as $parent) {
                        if ($parent->email) {
                            $recipients[] = $parent->email;
                        }
                    }
                }

                $recipients = array_unique($recipients);
                
                Log::info('Queueing announcement emails from teacher', [
                    'announcement_id' => $announcement->id,
                    'recipient_count' => count($recipients),
                    'recipients' => $recipients // Log actual email addresses for debugging
                ]);

                if (empty($recipients)) {
                    Log::warning('No recipients found for teacher announcement', [
                        'teacher_id' => $teacher->id,
                        'announcement_id' => $announcement->id,
                        'target' => $request->target
                    ]);
                    
                    return redirect()->route('teacher.announcements.index')
                        ->with('warning', 'Announcement created but no recipients were found to send emails to.');
                }

                // Queue emails for sending in the background
                foreach ($recipients as $email) {
                    SendAnnouncementEmail::dispatch($announcement, $email)->onQueue('emails');
                    Log::info('Queued email for recipient', [
                        'email' => $email,
                        'announcement_id' => $announcement->id
                    ]);
                }

                return redirect()->route('teacher.announcements.index')
                    ->with('success', 'Announcement created successfully and emails have been queued for sending to ' . count($recipients) . ' recipients');

            } catch (Exception $e) {
                Log::error('Error in teacher announcement email process', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'announcement_id' => $announcement->id
                ]);

                return redirect()->route('teacher.announcements.index')
                    ->with('warning', 'Announcement created but there was an issue queuing emails. Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    public function edit(Announcement $announcement)
    {
        $teacher = Auth::guard('teacher')->user();
        
        if ($announcement->created_by_id !== $teacher->id || $announcement->created_by_type !== 'App\Models\Teacher') {
            return redirect()->route('teacher.announcements.index')
                ->with('error', 'Unauthorized access');
        }
        
        return view('teacher.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $teacher = Auth::guard('teacher')->user();
        
        if ($announcement->created_by_id !== $teacher->id || $announcement->created_by_type !== 'App\Models\Teacher') {
            return redirect()->route('teacher.announcements.index')
                ->with('error', 'Unauthorized access');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy(Announcement $announcement)
    {
        $teacher = Auth::guard('teacher')->user();
        
        if ($announcement->created_by_id !== $teacher->id || $announcement->created_by_type !== 'App\Models\Teacher') {
            return redirect()->route('teacher.announcements.index')
                ->with('error', 'Unauthorized access');
        }

        $announcement->delete();

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}