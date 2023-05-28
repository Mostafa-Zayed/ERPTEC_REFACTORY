<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $apiNamespace = 'App\Http\Controllers\Api';
    
    protected $productsNamespace = 'App\Http\Controllers\Products';
    
    // protected $whatsappModuleNamespace = 'Modules\Whatsapp\Http\Controllers';
    
    protected $webhookNamespace = 'App';
    
    protected $superAdminModuleNamespace = 'Modules\Superadmin\Http\Controllers';
    
    // protected $websiteModuleNamespace = 'Modules\Website\Http\Controllers';
    
    // protected $storeModuleNamespace = 'Modules\Store\Http\Controllers';
    
    protected $frontNamespace       = 'App\Http\Controllers\Front';
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapProductsWebRoutes();
        
        // $this->mapWhatsappRoutes();
        
        $this->mapWebhookRoutes();
        
        $this->mapFrontWebRoutes();
        /* superadmin routes */
        // $this->mapSuperAdminRoutes();
        
        /* website routes */
        // $this->mapWebsiteRoutes();
        
        /* store routes */
        // $this->mapStoreRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }


    protected function mapProductsWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->productsNamespace)
            ->group(base_path('routes/products.php'));
    }
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->apiNamespace)
             ->group(base_path('routes/api.php'));
    }
    
    protected function mapWhatsappRoutes()
    {
        Route::prefix('whatsapp')->middleware('web')->name('whatsapp.')->namespace($this->whatsappModuleNamespace)->group(base_path('Modules/Whatsapp/Http/routes.php'));
    }
    
    protected function mapWebhookRoutes()
    {
        Route::prefix('webhook')->middleware([])->name('webhook.')->group(base_path('routes/webhook.php'));
    }
    
    protected function mapSuperAdminRoutes()
    {
        Route::prefix('superadmin')->name('superadmin.')->group(base_path('Modules/Superadmin/Http/routes.php'));
    }
    
    protected function mapWebsiteRoutes()
    {
        Route::prefix('website')->middleware('web')->name('website.')->namespace($this->websiteModuleNamespace)->group(base_path('Modules/Website/Http/routes.php'));
    }
    
    protected function mapStoreRoutes()
    {
        Route::prefix('store')->middleware('web')->name('store.')->namespace($this->storeModuleNamespace)->group(base_path('Modules/Store/Http/routes.php'));
    }
    
    protected function mapFrontWebRoutes()
    {
        Route::namespace($this->frontNamespace)->group(base_path('routes/front.php'));
    }
}
