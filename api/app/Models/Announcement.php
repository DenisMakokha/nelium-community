<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'priority',
        'status',
        'scheduled_at',
        'author_id'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
}
