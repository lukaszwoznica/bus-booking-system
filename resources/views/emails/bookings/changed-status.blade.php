@component('mail::message')
# Hello {{ $booking->user->first_name }}!

Your booking status was changed to **{{ $booking->status }}**.

### Booking summary
@component('mail::table')
| Departure                                                  | Arrival                                                 | Date                                         |  Seats                 |
|:----------------------------------------------------------:|:-------------------------------------------------------:|:--------------------------------------------:|:----------------------:|
| {{ $booking->startLocation->name }} - {{ $departureTime }} | {{ $booking->endLocation->name  }} - {{ $arrivalTime }} | {{ $booking->travel_date->format('d.m.Y') }} |  {{ $booking->seats }} |
@endcomponent

Thank you for using our application!<br><br>
Regards,<br>
{{ config('app.name') }}
@endcomponent
