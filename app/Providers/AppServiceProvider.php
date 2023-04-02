<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

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
        Blueprint::macro('humanName', function () {
            $this->string('name');
            $this->string('family');
            $this->string('prefix');
            $this->string('suffix');
        });
    }
}
