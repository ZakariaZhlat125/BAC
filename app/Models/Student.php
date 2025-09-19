<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'major',
        'points',
        'year',
        'bio',
        'is_upgraded',
        'specialization_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function yearRelation()
    {
        return $this->belongsTo(Year::class, 'year', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'student_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'student_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'student_id', 'id');
    }

    public function summaries()
    {
        return $this->hasMany(Summary::class, 'student_id', 'id');
    }
    public function  specializ()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'id');
    }
    public function upgradeRequest()
    {
        return $this->hasOne(UpgradeRequest::class, 'student_id', 'id');
    }


    public function getVolunteerHoursAttribute()
    {
        return intdiv($this->points, 10); // each 10 points = 1 hour
    }
}
