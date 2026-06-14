<?php

namespace App\Exports;

use App\Enums\ParkingTransactionStatus;
use App\Models\ParkingTransaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParkingHistoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected array $filters = []) {}

    public function collection(): Collection
    {
        $query = ParkingTransaction::query()
            ->with(['slot', 'vehicleType'])
            ->orderByDesc('checked_in_at');

        if (! empty($this->filters['date_from'])) {
            $query->whereDate('checked_in_at', '>=', $this->filters['date_from']);
        }

        if (! empty($this->filters['date_to'])) {
            $query->whereDate('checked_in_at', '<=', $this->filters['date_to']);
        }

        if (! empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'No Kamar',
            'Plat',
            'Slot',
            'Jenis Kendaraan',
            'Jam Masuk',
            'Jam Keluar',
            'Durasi',
            'Status',
        ];
    }

    /**
     * @param  ParkingTransaction  $row
     */
    public function map($row): array
    {
        return [
            $row->guest_name,
            $row->room_number,
            $row->plate_number,
            $row->slot?->slot_code,
            $row->vehicleType?->name,
            $row->checked_in_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') ?? '-',
            $row->checked_out_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') ?? '-',
            $row->durationHuman() ?? '-',
            $row->status instanceof ParkingTransactionStatus ? $row->status->value : (string) $row->status,
        ];
    }
}
