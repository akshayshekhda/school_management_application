<?php

namespace App\Jobs;

use App\Mail\AnnouncementMail;
use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $announcement;
    protected $email;

    public function __construct(Announcement $announcement, string $email)
    {
        $this->announcement = $announcement;
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new AnnouncementMail($this->announcement));
    }
}
