<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'slug',
        'description',
        'file_url',
        'link_url',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'tier_min',
        'tags',
        'published_at',
        'created_by'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeForTier(Builder $query, $userTier = 'FREE')
    {
        $tiers = ['FREE' => 0, 'IND' => 1, 'INST' => 2];
        $userLevel = $tiers[$userTier] ?? 0;
        
        return $query->where(function($q) use ($tiers, $userLevel) {
            foreach ($tiers as $tier => $level) {
                if ($level <= $userLevel) {
                    $q->orWhere('tier_min', $tier);
                }
            }
        });
    }
}
