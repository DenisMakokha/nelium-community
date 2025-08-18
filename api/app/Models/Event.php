<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'starts_at',
        'ends_at',
        'location_type',
        'location_text',
        'description',
        'tier_min',
        'rsvp_required',
        'created_by'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'rsvp_required' => 'boolean'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('starts_at', '>', now());
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
