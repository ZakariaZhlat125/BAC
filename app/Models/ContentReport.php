<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentReport extends Model
{
     use HasFactory;

    protected $table = 'content_reports';

    protected $fillable = [
        'type',
        'reason',
        'content_id',
    ];

    /**
     * The content that this report belongs to.
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }
}
