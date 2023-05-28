<?php

namespace Modules\Shipment\Providers;

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

        /* Products Model */
        $this->app->bind(
            'Modules\\Shipment\\Interfaces\\VooShipmentInterface',
            'Modules\\Shipment\\Repositories\\VooShipmentRepository'
        );

        /* Variation Template Model */
        // $this->app->bind(
        //     'Modules\\Shipment\\Interfaces\\VariationTemplateInterface',
        //     'Modules\\Shipment\\Repositories\\VariationTemplateRepository'
        // );

        // /* Brands Model */
        // $this->app->bind(
        //     'Modules\\Shipment\\Interfaces\BrandInterface',
        //     'Modules\\Shipment\\Repositories\\BrandRepository'
        // );

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
