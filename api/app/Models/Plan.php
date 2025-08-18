<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'price_cents',
        'currency',
        'billing_cycle',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price_cents' => 'integer'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getPriceAttribute()
    {
        return $this->price_cents / 100;
    }
}
