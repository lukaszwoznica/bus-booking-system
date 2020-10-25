<?php


namespace App;


class BookingStatus extends Enum
{
    const PROCESSING = 'processing';
    const CONFIRMED = 'confirmed';
    const REJECTED = 'rejected';
    const CANCELLED = 'cancelled';
}
