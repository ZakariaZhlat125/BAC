<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';

    protected $fillable = [
        'title',
        'description',
        'file',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'chapter_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'chapter_id', 'id');
    }
}
