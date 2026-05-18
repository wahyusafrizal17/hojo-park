<?php

namespace App\Services\Activity;

use App\Enums\ActivityAction;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $logs,
    ) {}

    public function log(
        ActivityAction|string $action,
        ?string $description = null,
        ?Model $subject = null,
        array $properties = [],
        ?int $userId = null,
    ): void {
        $actionValue = $action instanceof ActivityAction ? $action->value : $action;

        $this->logs->log([
            'user_id' => $userId ?? auth()->id(),
            'action' => $actionValue,
            'description' => $description,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
            'ip_address' => Request::ip(),
        ]);
    }
}
