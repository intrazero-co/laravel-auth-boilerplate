<?php

namespace Intrazero\AuthBoilerplate\Console;

use Illuminate\Console\Command;

class InstallAuthentication extends Command
{
    protected $signature = 'authentication:install';
    protected $description = 'Install and configure Passport or Sanctum for API authentication';

    public function handle()
    {
        $this->info("Welcome to the Intrazero Authentication Package Installation");

        // Prompt user for choice between Passport and Sanctum
        $choice = $this->choice(
            'Which authentication method would you like to install?',
            ['Passport', 'Sanctum'],
            0
        );

        if ($choice === 'Passport') {
            $this->installPassport();
        } else {
            $this->installSanctum();
        }

        $this->info("Authentication method $choice installed successfully!");
    }

    protected function installPassport()
    {
        $this->info("Installing Passport...");
        // Install Passport via Composer
        shell_exec('composer require laravel/passport');
        // Run necessary migrations and installation steps
        $this->call('migrate');
        $this->call('passport:install');
    }

    protected function installSanctum()
    {
        $this->info("Installing Sanctum...");
        // Install Sanctum via Composer
        shell_exec('composer require laravel/sanctum');
        // Run necessary migrations
        $this->call('migrate');
        $this->call('sanctum:install');
    }
}
