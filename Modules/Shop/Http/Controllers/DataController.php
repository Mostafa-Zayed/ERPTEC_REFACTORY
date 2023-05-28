<?php

namespace Modules\Shop\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;

class DataController extends Controller
{
    public function dummy_data()
    {
        Artisan::call('db:seed', ["--class" => 'Modules\Shop\Database\Seeders\AddDummySyncLogTableSeeder']);
    }

    public function superadmin_package()
    {
        return [
            [
                'name' => 'shop_module',
                'label' => __('shop::lang.shop_module'),
                'default' => false
            ]
        ];
    }

    /**
     * Defines user permissions for the module.
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'shop.access_api_settings',
                'label' => __('shop::lang.access_api_settings'),
                'default' => false
            ],
            [
                'value' => 'shop.sync_categories',
                'label' => __('shop::lang.sync_categories'),
                'default' => false
            ],
            [
                'value' => 'shop.show_sync',
                'label' => __('shop::lang.show_sync'),
                'default' => false
            ],
            [
                'value' => 'shop.sync_variations',
                'label' => __('shop::lang.sync_variations'),
                'default' => false
            ],
            [
                'value' => 'shop.sync_brands',
                'label' => __('shop::lang.sync_brands'),
                'default' => false
            ],
            [
                'value' => 'shop.sync_taxs',
                'label' => __('shop::lang.sync_taxs'),
                'default' => false
            ],
            [
                'value' => 'shop.sync_products',
                'label' => __('shop::lang.sync_products'),
                'default' => false
            ],
        ];
    }

    /**
     * Parses notification message from database.
     * @return array
     */
    public function parse_notification($notification)
    {
        // $notification_data = [];
        // if ($notification->type ==
        //     'Modules\Woocommerce\Notifications\SyncOrdersNotification') {
        //     $msg = __('woocommerce::lang.orders_sync_notification');

        //     $notification_data = [
        //         'msg' => $msg,
        //         'icon_class' => "fas fa-sync bg-light-blue",
        //         'link' =>  action('SellController@index'),
        //         'read_at' => $notification->read_at,
        //         'created_at' => $notification->created_at->diffForHumans()
        //     ];
        // }

        // return $notification_data;
    }

    /**
     * Returns product form part path with required extra data.
     *
     * @return array
     */
    public function product_form_part()
    {
        $path = 'shop::partials.product_form_part';

        $business_id = request()->session()->get('user.business_id');

        $module_util = new ModuleUtil();
        $is_woo_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'shop_module', 'superadmin_package');
        if ($is_woo_enabled) {
            return  [
                'template_path' => $path,
                'template_data' => []
            ];
        } else {
            return [];
        }
    }

    /**
     * Returns products table extra columns for this module
     *
     * @return array
     */
    public function product_form_fields()
    {
        return ['shop_disable_sync'];
    }

    /**
     * Adds Woocommerce menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $module_util = new ModuleUtil();
        
        $business_id = session()->get('user.business_id');
        $is_woo_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'shop_module', 'superadmin_package');

        if ($is_woo_enabled) {
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->url(
                    action('\Modules\Shop\Http\Controllers\ShopController@index'),
                    __('shop::lang.shop_module'),
                    ['icon' => 'fab fa-wordpress', 'style' => config('app.env') == 'demo' ? 'background-color: #9E458B !important;' : '', 'active' => request()->segment(1) == 'shop']
                )->order(400);
            });
        }
    }
}
