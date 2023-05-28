<?php

namespace Modules\Shipment\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;

class DataController extends Controller
{
    public function dummy_data()
    {
        Artisan::call('db:seed', ["--class" => 'Modules\Shipment\Database\Seeders\AddDummySyncLogTableSeeder']);
    }

    public function superadmin_package()
    {
        return [
            [
                'name' => 'shipment_module',
                'label' => __('shipment::lang.shipment_module'),
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
                'value' => 'shipment.show_companies',
                'label' => __('shipment::lang.show_companies'),
                'default' => false
            ],
            [
                'value' => 'shipment.add_account',
                'label' => __('shipment::lang.add_account'),
                'default' => false
            ],
            [
                'value' => 'shipment.show_accounts',
                'label' => __('shipment::lang.show_accounts'),
                'default' => false
            ],
            [
                'value' => 'shipment_zones',
                'label' => __('shipment::lang.zones'),
                'default' => false
            ],
            // [
            //     'value' => 'woocommerce.access_woocommerce_api_settings',
            //     'label' => __('woocommerce::lang.access_woocommerce_api_settings'),
            //     'default' => false
            // ],

        ];
    }

    /**
     * Parses notification message from database.
     * @return array
     */
    // public function parse_notification($notification)
    // {
    //     $notification_data = [];
    //     if ($notification->type ==
    //         'Modules\Woocommerce\Notifications\SyncOrdersNotification') {
    //         $msg = __('woocommerce::lang.orders_sync_notification');

    //         $notification_data = [
    //             'msg' => $msg,
    //             'icon_class' => "fas fa-sync bg-light-blue",
    //             'link' =>  action('SellController@index'),
    //             'read_at' => $notification->read_at,
    //             'created_at' => $notification->created_at->diffForHumans()
    //         ];
    //     }

    //     return $notification_data;
    // }

    /**
     * Returns product form part path with required extra data.
     *
     * @return array
     */
    // public function product_form_part()
    // {
    //     $path = 'woocommerce::woocommerce.partials.product_form_part';

    //     $business_id = request()->session()->get('user.business_id');

    //     $module_util = new ModuleUtil();
    //     $is_woo_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'woocommerce_module', 'superadmin_package');
    //     if ($is_woo_enabled) {
    //         return  [
    //             'template_path' => $path,
    //             'template_data' => []
    //         ];
    //     } else {
    //         return [];
    //     }
    // }

    /**
     * Returns products table extra columns for this module
     *
     * @return array
     */
    // public function product_form_fields()
    // {
    //     return ['woocommerce_disable_sync'];
    // }

    /**
     * Adds Woocommerce menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $module_util = new ModuleUtil();
        
        $business_id = session()->get('user.business_id');
        $is_shipment_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'shipment_module', 'superadmin_package');

        if ($is_shipment_enabled) {
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->url(
                    action('\Modules\Shipment\Http\Controllers\ShipmentController@index'),
                    __('shipment::lang.shipment'),
                    ['icon' => 'fab fa-wordpress', 'style' => config('app.env') == 'demo' ? 'background-color: #9E458B !important;' : '', 'active' => request()->segment(1) == 'shipment']
                )->order(300);
            });
        }
    }
}
