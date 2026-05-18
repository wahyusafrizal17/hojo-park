<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use Illuminate\Contracts\View\View;

class ParkingTicketController extends Controller
{
    public function show(string $token): View
    {
        $transaction = ParkingTransaction::query()
            ->where('qr_token', $token)
            ->with(['slot', 'vehicleType'])
            ->firstOrFail();

        return view('parking.ticket', [
            'transaction' => $transaction,
        ]);
    }
}
