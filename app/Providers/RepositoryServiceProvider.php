<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /* Business */
        $this->app->bind(
            'App\Interfaces\BusinessInterface',
            'App\Repositories\BusinessRepository'
        );
        
        /* Business Location */
        $this->app->bind(
            'App\\Interfaces\\BusinessLocationInterface',
            'App\\Repositories\\BusinessLocationRepository'
        );
        
        /* Role */
        $this->app->bind(
            'App\\Interfaces\\RoleInterface',
            'App\\Repositories\\RoleRepository'
        );
        
        /* User */
        $this->app->bind(
            'App\\Interfaces\\UserInterface',
            'App\\Repositories\\UserRepository'
        );
        
        /* Variation Templates */
        $this->app->bind(
            'App\\Interfaces\\VariationTemplateInterface',
            'App\\Repositories\\VariationTemplateRepository'
        );
        
        /* Categories */
        $this->app->bind(
            'App\\Interfaces\\CategoryInterface',
            'App\\Repositories\\CategoryRepository'
        );
        
        /* Products */
        $this->app->bind(
            'App\\Interfaces\\ProductInterface',
            'App\\Repositories\\ProductRepository'
        );
        
        /* Unit */
        $this->app->bind(
            'App\\Interfaces\\UnitInterface',
            'App\\Repositories\\UnitRepository'
        );
        
        /* Invoice Layouts */
        $this->app->bind(
            'App\\Interfaces\\InvoiceLayoutInterface',
            'App\\Repositories\\InvoiceLayoutRepository'
        );
        
        /* Invoice Scheme */
        $this->app->bind(
            'App\\Interfaces\\InvoiceSchemeInterface',
            'App\\Repositories\\InvoiceSchemeRepository'
        );
        
        /* Sell price group */
        $this->app->bind(
            'App\\Interfaces\\SellPriceGroupInterface',
            'App\\Repositories\\SellPriceGroupRepository'
        );
        
        /* Tax Rate */
        $this->app->bind(
            'App\Interfaces\\TaxRateInterface',
            'App\Repositories\\TaxRateRepository'
        );
        
        /* Brand */
        $this->app->bind(
            'App\\Interfaces\\BrandInterface',
            'App\Repositories\\BrandRepository'
        );
        
        /* Warranty */
        $this->app->bind(
            'App\Interfaces\WarrantyInterface',
            'App\Repositories\WarrantyRepository'
        );
        
        /* Contact */
        $this->app->bind(
            'App\\Interfaces\\ContactInterface',
            'App\\Repositories\\ContactRepository'
        );
        
        // /** Superadmin Module **/
        $this->app->bind(
            'Modules\\Superadmin\\Interfaces\\SuperadminInterface',
            'Modules\\Superadmin\\Repositories\\SuperadminRepository'
        );
        
        /* Transaction */
        $this->app->bind(
            'App\\Interfaces\\TransactionInterface',
            'App\\Repositories\\TransactionRepository'
        );
        
        /* Sell Transaction */
        $this->app->bind(
            'App\\Interfaces\\SellTransactionInterface',
            'App\\Repositories\\SellTransactionRepository'
        );
        
        /* Transaction Payment*/
        $this->app->bind(
            'App\\Interfaces\\TransactionPaymentInterface',
            'App\\Repositories\\TransactionPaymentRepository'
        );
        
        /* Reference Count */
        $this->app->bind(
            'App\\Interfaces\\ReferenceCountInterface',
            'App\\Repositories\\ReferenceCountRepository'
        );
        
        /* Module */
        $this->app->bind(
            'App\\Interfaces\\ModuleInterface',
            'App\\Repositories\\ModuleRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
