<?php

namespace App\Http\Requests\Parking;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole([
            User::ROLE_SECURITY,
            User::ROLE_ADMINISTRATOR,
        ]) ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'guest_name' => ['required', 'string', 'max:120'],
            'room_number' => ['required', 'string', 'max:32'],
            'plate_number' => ['required', 'string', 'max:32'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'scan_entry' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public static function livewireRules(string $prefix = 'checkIn'): array
    {
        return collect((new static)->rules())
            ->mapWithKeys(fn ($rules, $key) => ["{$prefix}.{$key}" => $rules])
            ->all();
    }
}
