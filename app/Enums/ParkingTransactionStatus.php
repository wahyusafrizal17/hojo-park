<?php

namespace App\Enums;

enum ParkingTransactionStatus: string
{
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
