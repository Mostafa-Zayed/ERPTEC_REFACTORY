<?php

namespace App\Repositories;

use App\Interfaces\BusinessInterface;
use App\User;
use Carbon\Carbon;
use App\Http\Traits\Util;
use App\Business;
use Spatie\Permission\Models\Role;
use App\Http\Traits\BusinessService;
use App\Repositories\RoleRepository;

class BusinessRepository implements BusinessInterface
{
    
    use Util;
    
    private $roleRepository;
    
    public function addBusiness($data)
    {
        return Business::create(self::getBusinessSettings($data));
    }
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function getAll($businessId)
    {
    }
    
    public function getById($business_id,array $select)
    {
        $query = DB::table('business');
        if($select)
            $query->select($select);
        return $query->find($business_id);
    }
    
    public function checkIsActive(&$business)
    {
        
    }
    
    public function create($data)
    {
        
    }
    
    public function update($businessId,$data)
    {
        
    }
    
    public function createNewBusiness(&$request,&$user)
    {
        
        
        $businessDetails = $this->getBusinessDetails($request);

        $businessDetails['owner_id'] = $user->id;

        if (!empty($businessDetails['start_date'])) {
            $businessDetails['start_date'] = Carbon::createFromFormat(config('business.default_date_format'), $businessDetails['start_date'])->toDateString();
        }

        //upload business logo
        $logo_name = Util::uploadFile($request, 'business_logo', 'business_logos', 'image');
        if (!empty($logo_name)) {
            $businessDetails['logo'] = $logo_name;
        }

        //default enabled modules
        $businessDetails['enabled_modules'] = $this->getDefaultEnabledModules();
        
        $businessDetails['sell_price_tax'] = config('business.sell_price_tax');

        $businessDetails['default_profit_percent'] = config('business.default_profit_percent');
        
        $businessDetails['keyboard_shortcuts'] = config('business.keyboard_shortcuts');
        
        $businessDetails['ref_no_prefixes'] = self::getRefNoPrefixes();
        
        $businessDetails['enable_inline_tax'] = config('business.enable_inline_tax');
        
        return Business::create($businessDetails);
        
    }

    public function getOwnerDetails(&$request)
    {
        $ownerData = $request->only(['surname', 'first_name', 'last_name', 'username', 'email', 'password', 'language']);

        $ownerData['language'] = empty($ownerData['language']) ? config('app.locale') : $ownerData['language'];

        return $ownerData;
    }

    public function getBusinessDetails(&$request)
    {
        $businessData = $request->only(['name', 'start_date', 'currency_id', 'time_zone']);
        $businessData['fy_start_month'] = 1;
        return $businessData;
    }

    public function getBusinessLocationDetails(&$request)
    {
        return $request->only(['name', 'country', 'state', 'city', 'zip_code', 'landmark', 'website', 'mobile', 'alternate_number']);
    }

    private function getDefaultEnabledModules()
    {
        return config('business.enabledModules');
    }

    private static function getRefNoPrefixes()
    {
        return config('business.ref_no_prefixes');
    }

    private static function getKeyBoardShortcuts()
    {
        return config('business.keyboardShortcuts');
    }
    
    public function newBusinessDefaultResources($businessId, $userId)
    {
        $user = User::find($userId);
        
        $user->assignRole(self::createAdminRole($businessId)->name);
        
        $cashierRole = self::createCashierRoleForBusiness($businessId);
        
        self::setRolePermissions($cashierRole,config('business.cashier_role_default_permissions'));
        
        $business = Business::findOrFail($businessId);
        
        // create or update reference counte 
        $contactsRefNumber = BusinessService::incrementReferenceCountWith('contacts',$businessId);
        
        $contactId = BusinessService::generateReferenceNumber('contacts',$contactsRefNumber,$businessId);
        
        BusinessService::createDefaultCustomer($businessId,$contactId,$userId);
        
        BusinessService::createDefaultInvoiceScheme($businessId);
        
        BusinessService::createDefaultInvoiceLayout($businessId);
        
        BusinessService::createDefaultUnit($businessId,$userId);
        
        BusinessService::createDefaultNotificationTemplates($businessId);

    }
    
    public function addDefaultResourceForBusiness($business,$user_id)
    {
        $user = DB::table('users')->find($user_id);
        $adminRole = $this->roleRepository->addAdminForBusiness($business->id);
        $user->assignRole($adminRole->name);
        $cashierRole = $this->roleRepository->addCashierForBusiness($business->id);
        $cashierRole->syncPermissions(config('business.cashier_roles'));
    }
    
    private static function createAdminRole($businessId)
    {
        return Role::create([ 'name' => 'Admin#' . $businessId,
                            'business_id' => $businessId,
                            'guard_name' => 'web', 'is_default' => 1
                        ]);
    }
    
    private static function createCashierRoleForBusiness($businessId)
    {
        return Role::create([ 'name' => 'Cashier#' . $businessId,
                            'business_id' => $businessId,
                            'guard_name' => 'web'
                        ]);
    }
    
    private static function setRolePermissions(&$role, $permissions)
    {
        $role->syncPermissions($permissions);
    }
    
    private static function getBusinessSettings(array &$data)
    {
        $data['sell_price_tax'] = config('business.sell_price_tax');

        $data['default_profit_percent'] = config('business.default_profit_percent');

        $data['keyboard_shortcuts'] = config('business.keyboard_shortcuts');

        $data['ref_no_prefixes'] = config('business.ref_no_prefixes'); 

        $data['enable_inline_tax'] = config('business.enable_inline_tax'); //0;
        
        $data['enabled_modules'] = config('business.enabled_modules');
        
        $data['fy_start_month'] = config('business.fy_start_month');
        
        return $data;
    }
    
    public function addLocation()
    {
        
    }
    /**
     * Increments reference count for a given type and given business
     * and gives the updated reference count
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    // public function setAndGetReferenceCount($type, $business_id = null)
    // {
    //     if (empty($business_id)) {
    //         $business_id = request()->session()->get('user.business_id');
    //     }

    //     $ref = ReferenceCount::where('ref_type', $type)
    //                       ->where('business_id', $business_id)
    //                       ->first();
    //     if (!empty($ref)) {
    //         $ref->ref_count += 1;
    //         $ref->save();
    //         return $ref->ref_count;
    //     } else {
    //         $new_ref = ReferenceCount::create([
    //             'ref_type' => $type,
    //             'business_id' => $business_id,
    //             'ref_count' => 1
    //         ]);
    //         return $new_ref->ref_count;
    //     }
    // }
}
