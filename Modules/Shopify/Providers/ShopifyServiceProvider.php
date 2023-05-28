<?php

namespace Modules\Shopify\Providers;

use App\Business;
use App\Utils\ModuleUtil;
use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        //TODO: Need to be removed.
        view::composer('shopify::layouts.partials.sidebar', function ($view) {
            $module_util = new ModuleUtil();

            if (auth()->user()->can('superadmin')) {
                $__is_woo_enabled = $module_util->isModuleInstalled('Shopify');
            } else {
                $business_id = session()->get('user.business_id');
                $__is_shopify_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'shopify_module', 'superadmin_package');
            }

            $view->with(compact('__is_shopify_enabled'));
        });

        $this->registerScheduleCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('shopify.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php',
            'shopify'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/shopify');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/shopify';
        }, \Config::get('view.paths')), [$sourcePath]), 'shopify');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/shopify');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shopify');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'shopify');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
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

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            \Modules\Woocommerce\Console\WooCommerceSyncOrder::class,
            \Modules\Woocommerce\Console\WoocommerceSyncProducts::class
        ]);
    }

    public function registerScheduleCommands()
    {
        $env = config('app.env');
        $module_util = new ModuleUtil();
        $is_installed = $module_util->isModuleInstalled(config('shopify.name'));
        
        if ($env === 'live' && $is_installed) {
            $businesses = Business::whereNotNull('shopify_api_settings')->get();

            foreach ($businesses as $business) {
                $api_settings = json_decode($business->shopify_api_settings);
                if (!empty($api_settings->enable_auto_sync)) {
                    //schedule command to auto sync orders
                    $this->app->booted(function () use ($business) {
                        $schedule = $this->app->make(Schedule::class);
                        $schedule->command('pos:WoocommerceSyncProducts ' . $business->id)->twiceDaily(1, 13);
                        $schedule->command('pos:WooCommerceSyncOrder ' . $business->id)->twiceDaily(1, 13);
                    });
                }
            }
        }
    }
}
