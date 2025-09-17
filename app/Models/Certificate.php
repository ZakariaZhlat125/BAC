<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = ['student_id', 'hours', 'certificate_number'];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
