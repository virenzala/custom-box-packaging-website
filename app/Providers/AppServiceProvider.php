<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!function_exists('openssl_cipher_iv_length')) {
            $fallback = new class implements \Illuminate\Contracts\Encryption\Encrypter {
                public function encrypt($value, $serialize = true) {
                    $payload = is_string($value) ? $value : serialize($value);
                    return 'raw:' . base64_encode($payload);
                }
                public function decrypt($payload, $unserialize = true) {
                    if (is_string($payload) && str_starts_with($payload, 'raw:')) {
                        $payload = substr($payload, 4);
                    }
                    $decoded = base64_decode($payload, true);
                    if ($decoded === false) return $payload;
                    if ($unserialize) {
                        $unserialized = @unserialize($decoded);
                        return $unserialized !== false ? $unserialized : $decoded;
                    }
                    return $decoded;
                }
                public function getKey() {
                    return config('app.key');
                }
                public function getAllKeys() {
                    return [config('app.key')];
                }
                public function getPreviousKeys() {
                    return [];
                }
            };

            $this->app->singleton('encrypter', fn () => $fallback);
            $this->app->alias('encrypter', \Illuminate\Contracts\Encryption\Encrypter::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('VERCEL') || env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
