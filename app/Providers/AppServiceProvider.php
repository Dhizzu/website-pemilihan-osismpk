<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log slow queries for optimization
        if (config('app.debug')) {
            DB::listen(function ($query) {
                if ($query->time > 1000) { // Log queries taking more than 1 second
                    Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms'
                    ]);
                }
            });
        }

        // Prevent N+1 queries by eager loading relationships
        \Illuminate\Database\Eloquent\Model::preventLazyLoading(!app()->isProduction());

        // Log memory usage for debugging
        if (config('app.debug')) {
            app()->terminating(function () {
                $peakMemory = memory_get_peak_usage(true) / 1024 / 1024;
                if ($peakMemory > 100) { // Log if memory usage exceeds 100MB
                    Log::warning('High memory usage detected', [
                        'peak_memory_mb' => round($peakMemory, 2),
                        'url' => request()->url(),
                        'method' => request()->method()
                    ]);
                }
            });
        }
    }
}
