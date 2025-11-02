<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'event_date',
        'event_time',
        'location',
        'attendees',
        'description',
        'supervisor_id',
        'student_id',
        'attach',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }

    public function participations()
    {
        return $this->hasMany(StudentParticipation::class, 'event_id', 'id');
    }
}
