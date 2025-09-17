<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionMessage extends Model
{
    use HasFactory;

    protected $table = 'discussion_messages';

    protected $fillable = [
        'message_content',
        'question',
        'discussion_id',
    ];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id', 'id');
    }
}
