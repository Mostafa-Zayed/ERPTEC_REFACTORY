<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shipment\Entities\Zone;
use Modules\Shipment\Http\Requests\ZoneRequest;
use Yajra\DataTables\Facades\DataTables;
use \DB;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Modules\Shipment\Entities\CityZone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');
        
        if(request()->ajax()){
            
            $zones = DB::table('zones')->select('id','name','name_ar','desc')->where('business_id','=',$business_id)->get();
            return Datatables::of($zones)
            ->addColumn(
                    'action',
                    '<button data-href="{{route(\'shipment.zones.edit\', [$id])}}" class="btn btn-xs main-bg-light text-white edit_variation_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                        
                        <button data-href="{{route(\'shipment.zones.destroy\', [$id])}}" class="btn btn-xs btn-danger delete_variation_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>'
                )
            ->removeColumn('id')
            ->rawColumns([3])
            ->make(false);
        }
        
        
        return view('shipment::zones.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $businessId = request()->session()->get('user.business_id');
        return view('shipment::zones.create',['business' => $businessId]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ZoneRequest $request)
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        
        try{
            
            $zone = Zone::create($request->validated());
            return ['success' => true,
                            'data' => $zone,
                            'msg' => __("brand.added_success")
                        ];
            
        }catch(\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }
        return $output;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        dd('here');
        return view('shipment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('shipment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function createCityZone()
    {
        $business_id = request()->user()->business_id;
        $country = Country::forDropdown($business_id, true);
        
        $zones = Zone::forDropdown($business_id, false);
        return view('shipment::zones.partials.add_zone_city',['country' => $country,'zones' => $zones]);
    }
    
    public function storeCityZone(Request $request)
    {
        
        try {
            $business_id = request()->user()->business_id;
            if($request->state_id) {
                $interest_array = $request->input('state_id');
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {
                    $old = CityZone::where('business_id',$business_id)->where('state_id',$interest_array[$i])->first();
                    if($old){
                        $old->zone_id = $request->zone_id ;
                        $old->update();
                    }else{
                        $city = new CityZone;
                        $city->business_id = $business_id ;
                        $city->zone_id = $request->zone_id ;
                        $city->state_id = $interest_array[$i];
                        $city->save();
                    }
                }
            }
            
            $output = [
                'success' => true,
                'msg' => __("brand.added_success")
            ];
                  
               
                        
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }

        return $output;
    }
    
    public function getCountryCities(Request $request)
    {
        
        $cities =City::where('country_id',$request->id)->get();
        
        $data = view('shipment::zones.partials.render_country_cities',compact('cities'))->render();
        return response()->json(['options'=>$data]);
    }
    
    public function getCityStates(Request $request)
    {
        $states = State::where('city_id',$request->id)->get();
        $data = view('shipment::zones.partials.render_city_states',compact('states'))->render();
        return response()->json(['options'=>$data]);
    }
}
