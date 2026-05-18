<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Parkir</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #e2e8f0; font-size: 10px; text-transform: uppercase; }
        h1 { font-size: 16px; margin: 0; }
        .meta { font-size: 10px; color: #64748b; margin-top: 4px; }
    </style>
</head>
<body>
    <h1>Riwayat Parkir</h1>
    <p class="meta">Diekspor {{ now()->timezone(config('app.timezone'))->format('d M Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Plat</th>
                <th>Slot</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row->guest_name }}</td>
                    <td>{{ $row->room_number }}</td>
                    <td>{{ $row->plate_number }}</td>
                    <td>{{ $row->slot?->slot_code }}</td>
                    <td>{{ $row->checked_in_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->checked_out_at ? $row->checked_out_at->timezone(config('app.timezone'))->format('Y-m-d H:i') : '—' }}</td>
                    <td>{{ $row->durationHuman() ?? '—' }}</td>
                    <td>{{ $row->status->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
