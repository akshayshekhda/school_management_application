<?php

// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'class',
        'bio',
        'roll_number',
        'teacher_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function parent()
    {
        return $this->hasOne(ParentModel::class);
    }
}