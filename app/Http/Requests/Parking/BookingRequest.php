<?php

namespace App\Http\Requests\Parking;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'guest_name' => ['required', 'string', 'max:120'],
            'room_number' => ['required', 'string', 'max:32'],
            'plate_number' => ['nullable', 'string', 'max:32'],
            'reserved_from' => ['required', 'date'],
            'reserved_until' => ['required', 'date', 'after:reserved_from'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public static function livewireRules(string $prefix = 'booking'): array
    {
        $rules = (new static)->rules();
        $rules['reserved_until'] = ['required', 'date', "after:{$prefix}.reserved_from"];

        return collect($rules)
            ->mapWithKeys(fn ($rule, $key) => ["{$prefix}.{$key}" => $rule])
            ->all();
    }
}
