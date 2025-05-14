<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Ensure Sanctum is properly configured
        if (!class_exists(Sanctum::class)) {
            throw new \RuntimeException('Sanctum is not installed. Run "composer require laravel/sanctum" to install it.');
        }

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
