<?php

namespace Amx\PackageBoilerplate\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Inertia::share('version', function () {
            return '1.0.0';
        });
    }

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../../config/package-boilerplate.php', 'package-boilerplate');
    }
}
