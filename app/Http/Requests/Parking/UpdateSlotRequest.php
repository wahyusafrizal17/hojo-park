<?php

namespace App\Http\Requests\Parking;

use App\Enums\ParkingSlotStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSlotRequest extends FormRequest
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
            'status' => ['required', Rule::enum(ParkingSlotStatus::class)],
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public static function livewireRules(): array
    {
        return (new static)->rules();
    }
}
