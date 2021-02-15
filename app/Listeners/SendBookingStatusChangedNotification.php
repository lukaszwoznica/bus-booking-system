<?php

namespace App\Listeners;

use App\Events\BookingStatusChanged;
use App\Notifications\BookingStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingStatusChangedNotification
{
    /**
     * Handle the event.
     *
     * @param BookingStatusChanged $event
     * @return void
     */
    public function handle(BookingStatusChanged $event)
    {
        $when = now()->addSeconds(15);
        $event->booking->user->notify((new BookingStatusChangedNotification($event->booking))->delay($when));
    }
}
