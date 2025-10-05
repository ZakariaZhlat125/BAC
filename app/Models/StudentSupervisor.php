<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSupervisor extends Model
{
    use HasFactory;

    protected $table = 'student_supervisors';

    protected $fillable = [
        'student_id',
        'supervisor_id',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
