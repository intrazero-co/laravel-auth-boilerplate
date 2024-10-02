<?php

namespace Intrazero\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Intrazero\Authentication\Services\AuthenticationManager;
use Intrazero\Authentication\Console\InstallAuthentication;
use Intrazero\Authentication\Contracts\TokenManagerInterface;
use Intrazero\Authentication\Managers\PassportTokenManager;
use Intrazero\Authentication\Managers\SanctumTokenManager;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish the config file if users want to customize it
        $this->publishes([
            __DIR__ . '/../../config/authentication.php' => config_path('authentication.php'),
            __DIR__.'/../Controllers/API/AuthController.php' => app_path('Http/Controllers/Auth/AuthController.php'),

        ]);

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }

    public function register()
    {

        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         InstallAuthentication::class,
        //     ]);
        // }

        // Register the token manager based on configuration
        $this->app->singleton(TokenManagerInterface::class, function ($app) {
            $authMethod = config('authentication.auth_method', 'sanctum');

            if ($authMethod === 'passport') {
                return new PassportTokenManager();
            }

            return new SanctumTokenManager();
        });


        // Register the AuthenticationManager and inject the token manager
        $this->app->singleton(AuthenticationManager::class, function ($app) {
            return new AuthenticationManager($app->make(TokenManagerInterface::class));
        });
        // Resolve the real path of the config file
        $configPath = __DIR__ . '/../../config/authentication.php';

        // Check if the path is valid before attempting to merge the config
        if ($configPath !== false && file_exists($configPath)) {
            $this->mergeConfigFrom($configPath, 'authentication');
        }

    }
}
