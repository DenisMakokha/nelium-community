<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'current_period_start',
        'current_period_end',
        'cancel_at_period_end',
        'gateway',
        'gateway_customer_id'
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'cancel_at_period_end' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->current_period_end->isFuture();
    }

    public function meetsTier($requiredTier)
    {
        if (!$this->isActive()) return false;
        
        $tiers = ['FREE' => 0, 'IND' => 1, 'INST' => 2];
        $currentTier = $tiers[$this->plan->code] ?? 0;
        $required = $tiers[$requiredTier] ?? 0;
        
        return $currentTier >= $required;
    }
}
