<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected  $fillable = [
        'title',
        'description',
        'image1',
        'image2',
        'image3',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
