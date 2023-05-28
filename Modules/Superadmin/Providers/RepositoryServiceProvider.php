<?php

namespace Modules\Superadmin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    
     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        /* Package Model */
        $this->app->bind(
            'Modules\\Superadmin\\Interfaces\\PackageInterface',
            'Modules\\Superadmin\\Repositories\\PackageRepository'
        );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}