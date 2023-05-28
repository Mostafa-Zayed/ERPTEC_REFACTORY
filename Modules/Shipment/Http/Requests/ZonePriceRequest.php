<?php

namespace Modules\Shipment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZonePriceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->isMethod('put') || request()->isMethod('patch')) {
            return self::UpdateRules();
        }
        
        return self::StoreRules();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    protected static function StoreRules()
    {
        
        return [
            'business_id' => ['required'],
            'value' => ['required'],
            'extra' => ['nullable'],
            'shipment_company_id' => ['required'],
            'shipment_account_id' => ['nullable'],
            'zone_id' => ['required'],
        ];
    }
    
    protected static function UpdateRules()
    {
        return [
           'business_id' => ['required'],
            'value' => ['required'],
            'extra' => ['nullable'],
            'shipment_company_id ' => ['required'],
            'shipment_account_id ' => ['nullable'],
            'zone_id ' => ['required'],
        ];
    }
    
    // public function attributes()
    // {
    //     return [
    //     ];
    // }
    
    // public function response(array $errors)
    // {
    //     if($this->ajax()){
    //         return response([
    //             'test' => 'test'
    //         ]);
    //     }
        
    //     return back()->withErrors()->withInput();
    // }
}
