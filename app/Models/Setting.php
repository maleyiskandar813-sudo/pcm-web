<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    private const CACHE_KEY = 'settings.all';

    private static ?array $resolved = null;

    /**
     * Ambil nilai setting; gunakan default bila belum tersimpan.
     * Seluruh setting di-cache dalam satu key (array) agar hanya 1 query per request.
     * Array dipakai (bukan objek) karena config `cache.serializable_classes` Laravel
     * menolak unserialize objek demi keamanan.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return self::cached()[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);

        self::flush();
    }

    public static function flush(): void
    {
        self::$resolved = null;

        Cache::forget(self::CACHE_KEY);
    }

    private static function cached(): array
    {
        if (self::$resolved !== null) {
            return self::$resolved;
        }

        return self::$resolved = Cache::rememberForever(self::CACHE_KEY, function () {
            return self::query()->pluck('value', 'key')->all();
        });
    }
}
