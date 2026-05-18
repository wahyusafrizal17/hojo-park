<?php

namespace App\Providers;

use App\Enums\ActivityAction;
use App\Models\User;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use App\Repositories\Contracts\ParkingSlotRepositoryInterface;
use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;
use App\Repositories\Eloquent\ActivityLogRepository;
use App\Repositories\Eloquent\ParkingSlotRepository;
use App\Repositories\Eloquent\ParkingTransactionRepository;
use App\Services\Activity\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ParkingSlotRepositoryInterface::class, ParkingSlotRepository::class);
        $this->app->bind(ParkingTransactionRepositoryInterface::class, ParkingTransactionRepository::class);
        $this->app->bind(ActivityLogRepositoryInterface::class, ActivityLogRepository::class);
        $this->app->singleton(ActivityLogger::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function (Login $event): void {
            /** @var User $user */
            $user = $event->user;

            app(ActivityLogger::class)->log(
                ActivityAction::Login,
                __('Pengguna :name masuk', ['name' => $user->name]),
                $user,
                ['email' => $user->email],
                $user->id,
            );
        });
    }
}
