<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
        'semester',
        'year_id',
        'difficulty',
        'specialization_id',
        'supervisor_id',
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'course_id', 'id');
    }

    public function specializ()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }


    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }
}
