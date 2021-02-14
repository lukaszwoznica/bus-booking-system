<?php


namespace App;


class BookingStatus extends Enum
{
    const NEW = 'new';
    const CONFIRMED = 'confirmed';
    const REJECTED = 'rejected';
    const CANCELLED = 'cancelled';
}
