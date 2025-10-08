<?php

namespace Amx\Salesforce\Providers;

use Illuminate\Support\ServiceProvider;

class SalesforceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Amx\Salesforce\Console\Commands\SyncSalesforceObject::class,
            ]);
        }
    }

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../../config/package-boilerplate.php', 'package-boilerplate');
    }
}
