<?php 

namespace App\Http\Traits;

use \Module;
use App\System;

trait ModuleService
{
    /**
     * This function check if a module is installed or not.
     *
     * @param string $module_name (Exact module name, with first letter capital)
     * @return boolean
     */
    public static function isModuleInstalled($moduleName)
    {
        if(Module::has(ucfirst($moduleName))){
            //Check if installed by checking the system table {module_name}_version
            $moduleVersion = System::getProperty(strtolower($moduleName) . '_version');
        }
        
        return empty($moduleVersion) ? false : true;
    }
    
    /**
     * This function check if superadmin module is installed or not.
     * @return boolean
     */
    public static function isSuperadminInstalled()
    {
        return self::isModuleInstalled('Superadmin');
    }
    
    /**
     * This function check if a business has active subscription packages
     *
     * @param int $business_id
     * @return boolean
     */
    public static function isSubscribed($businessId)
    {
        if (self::isSuperadminInstalled()) {
            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($businessId);
            if (empty($package)) {
                return false;
            }
        }
      
        return true;
    }
    
    /**
     * Returns the name of view used to display for subscription expired.
     *
     * @return string
     */
    public static function expiredResponse($redirect_url = null)
    {
        $response_array = ['success' => 0,
                        'msg' => __(
                            "superadmin::lang.subscription_expired_toastr",
                            ['app_name' => config('app.name'),
                                'subscribe_url' => action('\Modules\Superadmin\Http\Controllers\SubscriptionController@index')
                            ]
                        )
                    ];

        if (request()->ajax()) {
            
            if (request()->wantsJson()) {
                return $response_array;
            } else {
                return view('superadmin::subscription.subscription_expired_modal');
            }
            
        } else {
            if (is_null($redirect_url)) {
                return back()
                    ->with('status', $response_array);
            } else {
                return redirect($redirect_url)
                    ->with('status', $response_array);
            }
        }
    } 
    
    /**
     * This function check if a business has available quota for various types.
     *
     * @param string $type
     * @param int $business_id
     * @param int $total_rows default 0
     *
     * @return boolean
     */
    public static function isQuotaAvailable($type, $businessId, $totalRows = 0)
    {
        if(self::isSuperadminInstalled()) {
            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($businessId);
            if(empty($package)) {
                return false;
            }
            
            //Start
            $start_dt = $package->start_date->toDateTimeString();
            $end_dt = $package->end_date->endOfDay()->toDateTimeString();
            dd($start_dt,$end_dt);
        }
        
        return true;
    }
}