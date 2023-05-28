<?php

namespace Modules\Affilate\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;

class DataController extends Controller
{
    public function dummy_data()
    {
        Artisan::call('db:seed', ["--class" => 'Modules\Affilate\Database\Seeders\AddDummySyncLogTableSeeder']);
    }

    public function superadmin_package()
    {
        return [
            [
                'name' => 'affilate_module',
                'label' => __('affilate::lang.affilate_module'),
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
                'value' => 'affilate.show_affilate',
                'label' => __('affilate::lang.show_affilate'),
                'default' => false
            ],
            [
                'value' => 'affilate.affilate_log',
                'label' => __('affilate::lang.affilate_log'),
                'default' => false
            ],
            [
                'value' => 'affilate.affilate_paids_show',
                'label' => __('affilate::lang.affilate_paids_show'),
                'default' => false
            ],
            [
                'value' => 'affilate.affilate_paids_create',
                'label' => __('affilate::lang.affilate_paids_create'),
                'default' => false
            ],  
            [
                'value' => 'affilate.affilate_paids_delete',
                'label' => __('affilate::lang.affilate_paids_delete'),
                'default' => false
            ],
            [
                'value' => 'affilate.access_affilate_balance',
                'label' => __('affilate::lang.access_affilate_balance'),
                'default' => false
            ],  
            [
                'value' => 'affilate.show_notification',
                'label' => __('affilate::lang.show_notification'),
                'default' => false
            ], 
            [
                'value' => 'affilate.affilate_report_show',
                'label' => __('affilate::lang.affilate_report_show'),
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
        $notification_data = [];
        if ($notification->type ==
            'Modules\Affilate\Notifications\SyncOrdersNotification') {
            $msg = __('affilate::lang.orders_sync_notification');

            $notification_data = [
                'msg' => $msg,
                'icon_class' => "fas fa-sync bg-light-blue",
                'link' =>  action('SellController@index'),
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans()
            ];
        }

        return $notification_data;
    }

    /**
     * Returns product form part path with required extra data.
     *
     * @return array
     */
    public function product_form_part()
    {
        $path = 'affilate::affilate.partials.product_form_part';

        $business_id = request()->session()->get('user.business_id');

        $module_util = new ModuleUtil();
        $is_woo_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'affilate_module', 'superadmin_package');
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
        return ['affilate_comm','affilate_type'];
    }

    /**
     * Adds affilate menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $module_util = new ModuleUtil();
        
        $business_id = session()->get('user.business_id');
        $is_woo_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'affilate_module', 'superadmin_package');

        if ($is_woo_enabled && (auth()->user()->can('affilate.show_affilate') || auth()->user()->can('affilate.affilate_log') || auth()->user()->can('affilate.access_affilate_balance') )) {
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->url(
                    action('\Modules\Affilate\Http\Controllers\AffilateController@index'),
                    __('affilate::lang.affilate'),
                    ['icon' => 'fab fa-autoprefixer', 'style' => config('app.env') == 'demo' ? 'background-color: #9E458B !important;' : '', 'active' => request()->segment(1) == 'affilate']
                )->order(18);
            });
        }
    }
}
