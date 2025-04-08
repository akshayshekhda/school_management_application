<?php
// app/Models/Teacher.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'subject',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get all students assigned to this teacher.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get all announcements created by this teacher.
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'created_by');
    }
}