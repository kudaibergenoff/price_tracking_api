<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(env('ACCESS_TOKEN_TTL')));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(env('REFRESH_TOKEN_TTL')));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

    }
}
