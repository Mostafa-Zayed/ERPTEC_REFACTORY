<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shipment\Entities\Zone;
use Modules\Shipment\Entities\Company as ShipmentCompany;
use \DB;
use Yajra\DataTables\Facades\DataTables;
use Modules\Shipment\Entities\ShipmentPrice;
use Modules\Shipment\Http\Requests\ZonePriceRequest;

class ZonePriceController extends Controller
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
            
            $zones = ShipmentPrice::with(['zone:id,name','shipmentCompany:id,name'])->select('id','value','extra','zone_id','shipment_company_id')->where('business_id','=',$business_id)->get();
            return Datatables::of($zones)
            
            ->addColumn(
                    'action',
                    '<button data-href="{{route(\'shipment.zones.price.edit\', [$id])}}" class="btn btn-xs main-bg-light text-white edit_variation_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                        
                        <button data-href="{{route(\'shipment.zones.price.destroy\', [$id])}}" class="btn btn-xs btn-danger delete_variation_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>'
                )
            ->editColumn('zone',function(ShipmentPrice $price){
                
                return $price->zone->name;
            })
            -> removeColumn('zone_id')
            ->editColumn('shipment_company',function(ShipmentPrice $price){
                
                return $price->shipmentCompany->name;
            })
            -> removeColumn('shipment_company_id')
            ->rawColumns(['action'])
            ->removeColumn('id')
            ->make(true);
        }
        return view('shipment::zones.price.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $zones = Zone::forDropdown($business_id, false);
        $companies = ShipmentCompany::where('business_id',$business_id)->orwhere('business_id',null)->pluck('name','id');
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
        return view('shipment::zones.price.create',['zones' => $zones, 'companies' => $companies,'quick_add' => $quick_add]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ZonePriceRequest $request)
    {
        // dd($request->all());
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        
        try{
            
            $zone = ShipmentPrice::create($request->validated());
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
}
