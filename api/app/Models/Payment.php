<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'gateway',
        'txn_id',
        'amount_cents',
        'currency',
        'status',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array',
        'amount_cents' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getAmountAttribute()
    {
        return $this->amount_cents / 100;
    }
}
