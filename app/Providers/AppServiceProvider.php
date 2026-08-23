<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();

        // Register observers
        \App\Models\Achievement::observe(\App\Observers\AuditObserver::class);
        \App\Models\Bill::observe(\App\Observers\AuditObserver::class);
        \App\Models\Motion::observe(\App\Observers\AuditObserver::class);
        \App\Models\ConstituencyProject::observe(\App\Observers\AuditObserver::class);
        \App\Models\News::observe(\App\Observers\AuditObserver::class);
        \App\Models\Speech::observe(\App\Observers\AuditObserver::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
