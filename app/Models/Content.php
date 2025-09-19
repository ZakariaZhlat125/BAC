<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'contents';

    protected $fillable = [
        'title',
        'description',
        'type',
        'reason',
        'file',
        'video',
        'student_id',
        'supervisor_id',
        'chapter_id',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(ContentReport::class, 'content_id', 'id');
    }

    public function summary()
    {
        return  $this->hasOne(Summary::class,  'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
