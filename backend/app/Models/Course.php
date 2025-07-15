<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'duration',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function getTotalDurationAttribute()
    {
        return $this->modules->sum(function($module) {
            return $module->contents->sum('duration');
        });
    }

    public function getTotalContentsAttribute()
    {
        return $this->modules->sum(function($module) {
            return $module->contents->count();
        });
    }
}