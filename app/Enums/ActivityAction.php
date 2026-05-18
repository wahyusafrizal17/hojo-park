<?php

namespace App\Enums;

enum ActivityAction: string
{
    case Login = 'login';
    case SlotUpdate = 'slot_update';
    case CheckIn = 'check_in';
    case CheckOut = 'check_out';
    case BookingCreated = 'booking_created';
    case Other = 'other';
}
