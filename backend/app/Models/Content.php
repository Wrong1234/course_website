<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_TEXT = 'text';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';
    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_LINK = 'link';
    const TYPE_QUIZ = 'quiz';

    protected $fillable = [
        'module_id',
        'title',
        'type',
        'description',
        'content',
        'url',
        'file_path',
        'file_size',
        'alt_text',
        'external',
        'duration',
        'order',
        'video_length', // Optional field for video length
    ];

    protected $casts = [
        'external' => 'boolean',
        'file_size' => 'decimal:2',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}