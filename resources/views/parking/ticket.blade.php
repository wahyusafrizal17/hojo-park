<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tiket Parkir') }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-50 py-10 text-slate-900 antialiased">
    <div class="mx-auto max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
        <p class="text-center text-xs font-semibold uppercase tracking-[0.3em] text-red-600">{{ config('app.name') }}</p>
        <h1 class="mt-2 text-center text-xl font-bold">{{ __('Tiket Parkir') }}</h1>
        <p class="mt-1 text-center text-sm text-slate-500">{{ $transaction->slot?->slot_code }} · {{ $transaction->plate_number }}</p>
        <div class="mt-6 flex justify-center">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->margin(1)->generate(route('parking.ticket', $transaction->qr_token)) !!}
        </div>
        <dl class="mt-6 space-y-2 text-sm">
            <div class="flex justify-between border-b border-slate-100 py-2">
                <dt class="text-slate-500">{{ __('Tamu') }}</dt>
                <dd class="font-medium">{{ $transaction->guest_name }}</dd>
            </div>
            <div class="flex justify-between border-b border-slate-100 py-2">
                <dt class="text-slate-500">{{ __('Kamar') }}</dt>
                <dd class="font-medium">{{ $transaction->room_number }}</dd>
            </div>
            <div class="flex justify-between border-b border-slate-100 py-2">
                <dt class="text-slate-500">{{ __('Masuk') }}</dt>
                <dd class="font-medium">{{ $transaction->checked_in_at?->timezone(config('app.timezone'))->format('d M Y H:i') }}</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-slate-500">{{ __('Jenis') }}</dt>
                <dd class="font-medium">{{ $transaction->vehicleType?->name }}</dd>
            </div>
        </dl>
    </div>
</body>
</html>
