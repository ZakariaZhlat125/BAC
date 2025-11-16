<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParticipation extends Model
{
    use HasFactory;

    protected $table = 'student_participations';
    protected $fillable = [
        'description',
        'attendance_status',
        'is_attended',
        'feedback',
        'student_id',
        'event_id',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
