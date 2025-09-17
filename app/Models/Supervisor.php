<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'supervisors';

    protected $fillable = [
        'user_id',
        'specialization_id',
        'department_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'supervisor_id', 'id');
    }

    public function contentReports()
    {
        return $this->hasMany(ContentReport::class, 'supervisor_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'supervisor_id', 'id');
    }

    public function upgradeRequests()
    {
        return $this->hasMany(UpgradeRequest::class, 'supervisor_id', 'id');
    }
}
