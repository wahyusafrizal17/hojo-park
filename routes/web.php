<?php

use App\Http\Controllers\ParkingExportController;
use App\Http\Controllers\ParkingTicketController;
use App\Livewire\Actions\Logout;
use App\Livewire\Dashboard\Overview;
use App\Livewire\Parking\ActivityLog as ParkingActivityLogPage;
use App\Livewire\Parking\History as ParkingHistoryPage;
use App\Livewire\Parking\Map as ParkingMapPage;
use App\Livewire\Profile\Manage as ProfileManagePage;
use App\Livewire\Settings\Manage as SettingsManagePage;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::post('/logout', function (Logout $logout) {
    $logout();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::get('/parking/ticket/{token}', [ParkingTicketController::class, 'show'])
    ->name('parking.ticket');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Overview::class)->name('dashboard');
    Route::get('/parking', ParkingMapPage::class)->name('parking.map');
    Route::get('/profile', ProfileManagePage::class)->name('profile');

    Route::middleware('role:'.User::ROLE_ADMINISTRATOR)->group(function () {
        Route::get('/parking/history', ParkingHistoryPage::class)->name('parking.history');
        Route::get('/parking/history/export/excel', [ParkingExportController::class, 'excel'])->name('parking.history.excel');
        Route::get('/parking/history/export/pdf', [ParkingExportController::class, 'pdf'])->name('parking.history.pdf');
        Route::get('/parking/activity', ParkingActivityLogPage::class)->name('parking.activity');
        Route::get('/settings', SettingsManagePage::class)->name('settings');
    });
});

require __DIR__.'/auth.php';
