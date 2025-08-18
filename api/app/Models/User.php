<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'org',
        'role',
        'country',
        'profession',
        'bio',
        'avatar_url',
        'privacy_opt_out'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'privacy_opt_out' => 'boolean'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function activeSubscription()
    {
        return $this->subscription()->where('status', 'active')
                   ->where('current_period_end', '>', now())
                   ->first();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'created_by');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function eventRsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function getCurrentTier()
    {
        $subscription = $this->activeSubscription();
        return $subscription ? $subscription->plan->code : 'FREE';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
