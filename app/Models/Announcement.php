<?php

// app/Models/Announcement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'target',
        'created_by_id',
        'created_by_type',
    ];

    /**
     * Get the creator of the announcement (admin or teacher).
     */
    public function created_by()
    {
        return $this->morphTo();
    }

    /**
     * Get the admin who created the announcement.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by_id')
            ->where('created_by_type', 'App\Models\Admin');
    }

    /**
     * Get the teacher who created the announcement.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'created_by_id')
            ->where('created_by_type', 'App\Models\Teacher');
    }
}