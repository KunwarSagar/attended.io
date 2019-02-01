<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasSlug;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'admin' => 'bool',
        'can_create_events_immediately' => 'bool',
    ];

    public function reviews(): HasMany
    {
        $this->hasMany(Review::class);
    }

    public function events()
    {
        return $this->morphedByMany(Event::class, 'ownable');
    }

    public function slots()
    {
        return $this->morphedByMany(Slot::class, 'ownable');
    }
}
