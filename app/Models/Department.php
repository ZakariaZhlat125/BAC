<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        // add other department-specific fields if any
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id', 'id');
    }
}
