<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    public const KEY_SECURITY_PASSWORD = 'security_access_password';

    public const KEY_ADMINISTRATOR_PASSWORD = 'administrator_access_password';

    public const KEY_ZONE_FRONT_CAPACITY = 'zone_front_capacity';

    public const KEY_ZONE_SIDE_CAPACITY = 'zone_side_capacity';

    public const KEY_ZONE_REAR_CAPACITY = 'zone_rear_capacity';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("system_setting.{$key}", function () use ($key, $default) {
            return static::query()->where('key', $key)->value('value') ?? $default;
        });
    }

    public static function setValue(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );

        Cache::forget("system_setting.{$key}");
    }

    public static function forgetCache(): void
    {
        foreach ([
            self::KEY_SECURITY_PASSWORD,
            self::KEY_ADMINISTRATOR_PASSWORD,
            self::KEY_ZONE_FRONT_CAPACITY,
            self::KEY_ZONE_SIDE_CAPACITY,
            self::KEY_ZONE_REAR_CAPACITY,
        ] as $key) {
            Cache::forget("system_setting.{$key}");
        }
    }
}
