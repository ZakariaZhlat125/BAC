<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpgradeRequest extends Model
{
    use HasFactory;

    protected $table = 'upgrade_requests';

    protected $fillable = [
        'status',
        'reason',
        'attach_file',
        'student_id',
        'supervisor_id',
    ];

    /**
     * Get the student associated with the upgrade request.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * Get the supervisor associated with the upgrade request.
     */
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }
}
