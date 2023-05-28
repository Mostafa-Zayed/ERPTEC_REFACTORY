<?php

namespace Modules\Shipment\Providers;

use App\Business;
use App\Utils\ModuleUtil;
use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class ShipmentServiceProvider extends ServiceProvider
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
        view::composer('shipment::layouts.partials.sidebar', function ($view) {
            $module_util = new ModuleUtil();

            if (auth()->user()->can('superadmin')) {
                $__is_woo_enabled = $module_util->isModuleInstalled('Shipment');
            } else {
                $business_id = session()->get('user.business_id');
                $__is_shipment_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'shipment_module', 'superadmin_package');
            }

            $view->with(compact('__is_shipment_enabled'));
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
            __DIR__.'/../Config/config.php' => config_path('shipment.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php',
            'shipment'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/shipment');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/shipment';
        }, \Config::get('view.paths')), [$sourcePath]), 'shipment');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/shipment');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shipment');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'shipment');
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
        $is_installed = $module_util->isModuleInstalled(config('shipment.name'));
        
        if ($env === 'live' && $is_installed) {
            $businesses = Business::whereNotNull('woocommerce_api_settings')->get();

            foreach ($businesses as $business) {
                $api_settings = json_decode($business->woocommerce_api_settings);
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
