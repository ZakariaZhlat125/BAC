<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $table = 'discussions';

    protected $fillable = [
        'chapter_id',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(DiscussionMessage::class, 'discussion_id', 'id');
    }
}
