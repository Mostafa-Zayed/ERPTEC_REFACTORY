<?php

namespace App\Repositories\Shipment;

use App\Interfaces\Shipment\MylerzShipmentInterface;
use App\Models\ShipmentSetting;

class MylerzShipmentReposiotry implements MylerzShipmentInterface
{
    public function index()
    {
        dd('mylerz index page');
    }
    
    public function updateSettings($request)
    {
        if (!auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $id = $request->setting_id;
        
        $input = $request->only(['mylerz_user','mylerz_password','mylerz_settings']);
        
        $input['mylerz_settings'] = json_encode($request->mylerz_settings);
        
        $mylerzSettings = ShipmentSetting::select('id','mylerz_user','mylerz_password')->find($id)->update($input);
        
        $output = ['success' => true,
                    'msg' => __("settings.updated_success"),
                    'url' => url('shipment')
            ];
        
        return $output;
    }
}