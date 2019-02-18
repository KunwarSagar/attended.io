<?php

namespace App\Domain\Slot\Notifications;

use App\Domain\Slot\Models\Slot;
use App\Domain\User\Models\User;
use App\Domain\Shared\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class SlotOwnershipClaimRejectedNotification extends BaseNotification
{
    /** @var \App\Mail\User */
    public $claimingUser;

    /** @var \App\Domain\Slot\Models\Slot */
    public $slot;

    public function __construct(User $claimingUser, Slot $slot)
    {
        $this->claimingUser = $claimingUser;

        $this->slot = $slot;
    }

    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject("Your claim on {{ $this->slot->name }} has been rejected")
            ->markdown('notification-mails.slot-ownership-claim-rejected', [
                'claimingUser' => $this->claimingUser,
                'slot' => $this->slot,
            ]);
    }
}
