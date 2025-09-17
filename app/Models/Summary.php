<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;

    protected $table = 'summaries';

    protected $fillable = [
        'type',       // مثل (اقتراح، تعديل، ملاحظات)
        'notes',      // ملخص/تعليق من المشرف
        'content_id',
        'supervisor_id',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
