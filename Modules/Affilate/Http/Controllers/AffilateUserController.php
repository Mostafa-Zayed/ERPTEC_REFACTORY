<?php

namespace Modules\Affilate\Http\Controllers;

use App\BusinessLocation;
use App\Business;
use App\Contact;
use App\System;
use App\User;
use App\Account;
use App\Variation;
use App\Utils\ModuleUtil;
use DB;
use Modules\Affilate\Entities\AffilateSyncLog;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AffilateUserController extends Controller
{
    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
       // dd(request()->segment(2));
        $business_id = request()->segment(2);

        //Check if subscribed or not, then check for users quota
        if (!$this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse();
        } elseif (!$this->moduleUtil->isQuotaAvailable('users', $business_id)) {
            return $this->moduleUtil->quotaExpiredResponse('users', $business_id, action('ManageUserController@index'));
        }

       
        $username_ext = $this->getUsernameExtension();
        $contacts = Contact::contactDropdown($business_id, true, false);
        $roles  = $this->getRolesArray($business_id);
  

        //Get user form part from modules
        $form_partials = $this->moduleUtil->getModuleData('moduleViewPartials', ['view' => 'manage_user.create']);

        return view('affilate::user.create')
                ->with(compact('username_ext', 'contacts', 'roles', 'business_id',  'form_partials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        try {
            $user_details = $request->only(['surname', 'first_name', 'last_name', 'username', 'email', 'password', 'selected_contacts', 'marital_status',
                'blood_group', 'contact_number', 'fb_link', 'twitter_link', 'social_media_1', 'transaction_number',
                'social_media_2', 'permanent_address', 'current_address','basic_salary','duration_unit',
                'guardian_name', 'custom_field_1', 'custom_field_2',
                'custom_field_3', 'custom_field_4', 'id_proof_name', 'id_proof_number', 'cmmsn_percent', 'gender']);
            
            $user_details['status'] = 'inactive';
              $user_details['carrier_agent'] =  0;
              $user_details['affilate_agent'] =  1 ;
              $business_id = $request->business_id;
              
              
            if (!isset($user_details['selected_contacts'])) {
                $user_details['selected_contacts'] = false;
            }

          /*  */if (!empty($request->input('dob'))) {
                $user_details['dob'] = $this->moduleUtil->uf_date($request->input('dob'));
            }

            if (!empty($request->input('bank_details'))) {
                $user_details['bank_details'] = json_encode($request->input('bank_details'));
            }

          
            $user_details['business_id'] = $business_id;
            $user_details['password'] = Hash::make($user_details['password']);

            $ref_count = $this->moduleUtil->setAndGetReferenceCount('username',$business_id);
            if (blank($user_details['username'])) {
                $user_details['username'] = $this->moduleUtil->generateReferenceNumber('username', $ref_count);
            }

            $username_ext = $this->getUsernameExtension();
            if (!empty($username_ext)) {
                $user_details['username'] .= $username_ext;
            }

            //Check if subscribed or not, then check for users quota
           /**/ if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse();
            } elseif (!$this->moduleUtil->isQuotaAvailable('users', $business_id)) {
                return $this->moduleUtil->quotaExpiredResponse('users', $business_id, action('ManageUserController@index'));
            }

            //Sales commission percentage
            $user_details['cmmsn_percent'] =  0;



            //Create the user
            $user = User::create($user_details);

           $role_id = $request->input('role');
            $role = Role::findOrFail($role_id);
            $user->assignRole($role->name); /**/

            AffilateSyncLog::create([
                'business_id' =>  $business_id ,
                'created_by' =>  $user->id ,
                'operation_type' =>  'created' ,
                'sync_type' =>  'users' 
                
                
                ]);

            //Assign selected contacts
          /*  if ($user_details['selected_contacts'] == 1) {
                $contact_ids = $request->get('selected_contact_ids');
                $user->contactAccess()->sync($contact_ids);
            }*/

            //Grant Location permissions
         /*   $this->giveLocationPermissions($user, $request);
             $this->giveAccountPermissions($user, $request);*/

           /* //Save module fields for user
            $this->moduleUtil->getModuleData('afterModelSaved', ['event' => 'user_saved', 'model_instance' => $user]);
*/


            $output = ['success' => 1,
                        'msg' => __("user.user_added"),
                        'user' => $user,
                    ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }

        return redirect('affilate/welcome')->with('status', $output);
    }

    public function welcome(Request $request)
    {
     
      $status = \Session::get('status');
        return view('affilate::user.welcome',compact('status'));
    }

  
      public function postCheckEmail(Request $request)
    {
        $email = $request->input('email');

        $query = User::where('email', $email);

        if (!empty($request->input('user_id'))) {
            $user_id = $request->input('user_id');
            $query->where('id', '!=', $user_id);
        }

        $exists = $query->exists();
        if (!$exists) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }

   public function postCheckUsername(Request $request)
    {
        $username = $request->input('username');

        if (!empty($request->input('username_ext'))) {
            $username .= $request->input('username_ext');
        }

        $count = User::where('username', $username)->count();
        if ($count == 0) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    private function getUsernameExtension()
    {
        $extension =  '';
        return $extension;
    }

    /**
     * Retrives roles array (Hides admin role from non admin users)
     *
     * @param  int  $business_id
     * @return array $roles
     */
    private function getRolesArray($business_id)
    {
        $roles_array = Role::where('business_id', $business_id)->get()->pluck('name', 'id');
        $roles = [];

      //  $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        foreach ($roles_array as $key => $value) {
          if ($value == 'Admin#' . $business_id) {
                continue;
            } /* */
            $roles[$key] = str_replace('#' . $business_id, '', $value);
        }
        return $roles;
    }

    /**
     * Adds or updates location permissions of a user
     */
    private function giveLocationPermissions($user, $request)
    {
        $permitted_locations = $user->permitted_locations();
        $permissions = $request->input('access_all_locations');
        $revoked_permissions = [];
        //If not access all location then revoke permission
        if ($permitted_locations == 'all' && $permissions != 'access_all_locations') {
            $user->revokePermissionTo('access_all_locations');
        }

        //Include location permissions
        $location_permissions = $request->input('location_permissions');
        if (empty($permissions) &&
            !empty($location_permissions)) {
            $permissions = [];
            foreach ($location_permissions as $location_permission) {
                $permissions[] = $location_permission;
            }

            if (is_array($permitted_locations)) {
                foreach ($permitted_locations as $key => $value) {
                    if (!in_array('location.' . $value, $permissions)) {
                        $revoked_permissions[] = 'location.' . $value;
                    }
                }
            }
        }

        if (!empty($revoked_permissions)) {
            $user->revokePermissionTo($revoked_permissions);
        }

        if (!empty($permissions)) {
            $user->givePermissionTo($permissions);
        } else {
            //if no location permission given revoke previous permissions
            if (!empty($permitted_locations)) {
                $revoked_permissions = [];
                foreach ($permitted_locations as $key => $value) {
                    $revoke_permissions[] = 'location.' . $value;
                }

                $user->revokePermissionTo($revoke_permissions);
            }
        }
    }
    
    
    private function giveAccountPermissions($user, $request)
    {
        $permitted_accounts = $user->permitted_accounts();
        $permissions = $request->input('access_all_accounts');
        $revoked_permissions = [];
        //If not access all location then revoke permission
        if ($permitted_accounts == 'all' && $permissions != 'access_all_accounts') {
            $user->revokePermissionTo('access_all_accounts');
        }

        //Include location permissions
        $account_permissions = $request->input('account_permissions');
        if (empty($permissions) &&
            !empty($account_permissions)) {
            $permissions = [];
            foreach ($account_permissions as $account_permission) {
                $permissions[] = $account_permission;
            }

            if (is_array($permitted_accounts)) {
                foreach ($permitted_accounts as $key => $value) {
                    if (!in_array('account.' . $value, $permissions)) {
                        $revoked_permissions[] = 'account.' . $value;
                    }
                }
            }
        }

        if (!empty($revoked_permissions)) {
            $user->revokePermissionTo($revoked_permissions);
        }

        if (!empty($permissions)) {
            $user->givePermissionTo($permissions);
        } else {
            //if no location permission given revoke previous permissions
            if (!empty($permitted_accounts)) {
                $revoked_permissions = [];
                foreach ($permitted_accounts as $key => $value) {
                    $revoke_permissions[] = 'account.' . $value;
                }

                $user->revokePermissionTo($revoke_permissions);
            }
        }
    }
    
    
        public function affiliate_products(Request $request){
             $location_id = request()->get('location_id', null);

            $business_id = $request->session()->get('user.business_id');
            $business = Business::find($business_id);

            $products = Variation::join('products as p', 'variations.product_id', '=', 'p.id')
            ->join('product_locations', 'product_locations.product_id', '=', 'p.id')
                ->join('product_variations as pv', 'variations.product_variation_id', '=', 'pv.id')
                ->leftjoin(
                    'variation_location_details AS VLD',
                    function ($join) use ($location_id) {
                        $join->on('variations.id', '=', 'VLD.variation_id');

                        //Include Location
                        if (!empty($location_id)) {
                            $join->where(function ($query) use ($location_id) {
                                $query->where('VLD.location_id', '=', $location_id);
                              
                                //Check null to show products even if no quantity is available in a location.
                                //TODO: Maybe add a settings to show product not available at a location or not.
                                $query->orWhereNull('VLD.location_id');
                                 
                            });
                            ;
                        }
                    }
                );
                //Hide products not available in the selected location
                
      //Filter by location
       
            $permitted_locations = auth()->user()->permitted_locations();

            if (!empty($location_id)) {
                if ($permitted_locations == 'all' || in_array($location_id, $permitted_locations)) {
                  
                   $products->where('product_locations.location_id', '=', $location_id);
                 
                }
            } else {
                if ($permitted_locations != 'all') {
                   
                        $products->whereIn('product_locations.location_id', $permitted_locations);
                   
                } else {
                    $products->with('product','product.product_locations');
                }
            }


            $affiliate_products = $products->select(
                'p.id as product_id',
                'p.name',
                'p.type',
                'p.affilate_comm',
                'p.affilate_type',
                'p.enable_stock',
                'p.image as product_image',
                'variations.id',
                'variations.sell_price_inc_tax',
                'variations.name as variation',
                'pv.name as vp',
                'VLD.qty_available',
                'variations.default_sell_price as selling_price',
                'variations.sub_sku'
            )->where('p.business_id', $business_id)
            ->with(['media'])->groupBy('variations.id')
            ->orderBy('p.name', 'asc')
            ->orderBy('pv.name', 'asc')
            ->paginate(48);

            return view('affilate::user.products')
                    ->with(compact('affiliate_products','business'));
    
    }
}
