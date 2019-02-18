<?php

namespace App\Domain\Slot\Models;

use App\Domain\Event\Models\Event;
use App\Domain\User\Models\User;
use App\Domain\Shared\Models\BaseModel;
use App\Models\Concerns\HasOwners;
use App\Domain\Review\Models\Concerns\HasReviews;
use App\Models\Concerns\HasShortSlug;
use App\Models\Concerns\HasSlug;
use App\Models\Interfaces\Ownable;
use App\Domain\Review\Interfaces\Reviewable;
use App\Domain\Slot\Models\Presenters\PresentsSlot;
use App\Domain\Slot\Models\SlotOwnershipClaim;
use App\Domain\Event\Models\Track;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slot extends BaseModel implements Reviewable, Ownable
{
    use HasReviews,
        HasSlug,
        HasShortSlug,
        HasOwners,
        PresentsSlot;

    public $dates = [
        'starts_at',
        'ends_at',
    ];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trackName(): string
    {
        return optional($this->track)->name ?? '';
    }

    public function claimingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'slot_ownership_claims')->withTimestamps();
    }

    public function claims(): HasMany
    {
        return $this->hasMany(SlotOwnershipClaim::class);
    }

    public function invitedToBeOwners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'slot_ownership_invites')->withTimestamps();
    }

    public function isAdministeredBy(User $user): bool
    {
        return $user->owns($this->event);
    }

    public function eventOfReviewable(): Event
    {
        return $this->event;
    }
}
