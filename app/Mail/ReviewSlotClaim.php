<?php

namespace App\Mail;

use App\Models\PendingOwnership;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewSlotClaim extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Mail\User */
    protected $claimingUser;

    /** @var \App\Models\Slot */
    protected $slot;

    public function __construct(User $claimingUser, Slot $slot)
    {
        $this->claimingUser = $claimingUser;

        $this->slot = $slot;
    }

    public function build()
    {
        return $this
            ->subject("{{ $this->claimingUser->email }} wants to claim slot named '{{ $this->slot->name }}'")
            ->markdown('mails.review-slot-claim');
    }
}
