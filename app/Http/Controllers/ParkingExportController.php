<?php

namespace App\Http\Controllers;

use App\Exports\ParkingHistoryExport;
use App\Models\ParkingSlot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ParkingExportController extends Controller
{
    public function excel(): BinaryFileResponse
    {
        Gate::authorize('exportHistory', ParkingSlot::class);

        $filters = request()->only(['date_from', 'date_to', 'status']);

        return Excel::download(new ParkingHistoryExport($filters), 'riwayat-parkir.xlsx');
    }

    public function pdf(): Response
    {
        Gate::authorize('exportHistory', ParkingSlot::class);

        $filters = request()->only(['date_from', 'date_to', 'status']);
        $rows = (new ParkingHistoryExport($filters))->collection();

        $pdf = Pdf::loadView('exports.parking-history-pdf', [
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('riwayat-parkir.pdf');
    }
}
