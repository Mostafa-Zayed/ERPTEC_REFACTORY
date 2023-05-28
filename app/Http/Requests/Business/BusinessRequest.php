<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? self::onUpdate() : self::onCreate();
    }

   
    
    public static function onCreate()
    {
        return [
            'name' => 'required|max:255',
            'currency_id' => 'required|numeric',
            'country' => 'required|max:255|string',
            // 'state' => 'required|max:255',
            // 'city' => 'required|max:255',
            // 'zip_code' => 'required|max:255',
            // 'landmark' => 'required|max:255',
            // 'time_zone' => 'required|max:255',
            // 'surname' => 'max:10',
            'email' => 'sometimes|nullable|email|unique:users,email|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|min:4|max:255|unique:users,username',
            'password' => 'required|min:4|max:255',
            'confirm_password' => 'required|min:4',
            // 'fy_start_month' => 'required',
            // 'accounting_method' => 'required',
        ];
    }
    
    protected static function onUpdate()
    {
        return [
        ];
    }
    
    
     public function message()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('business.business_name')]),
            'name.currency_id' => __('validation.required', ['attribute' => __('business.currency')]),
            'country.required' => __('validation.required', ['attribute' => __('business.country')]),
            'state.required' => __('validation.required', ['attribute' => __('business.state')]),
            'city.required' => __('validation.required', ['attribute' => __('business.city')]),
            'zip_code.required' => __('validation.required', ['attribute' => __('business.zip_code')]),
            'landmark.required' => __('validation.required', ['attribute' => __('business.landmark')]),
            'time_zone.required' => __('validation.required', ['attribute' => __('business.time_zone')]),
            'email.email' => __('validation.email', ['attribute' => __('business.email')]),
            'email.email' => __('validation.unique', ['attribute' => __('business.email')]),
            'first_name.required' => __('validation.required', ['attribute' =>
            __('business.first_name')]),
            'username.required' => __('validation.required', ['attribute' => __('business.username')]),
            'username.min' => __('validation.min', ['attribute' => __('business.username')]),
            'password.required' => __('validation.required', ['attribute' => __('business.username')]),
            'password.min' => __('validation.min', ['attribute' => __('business.username')]),
            'fy_start_month.required' => __('validation.required', ['attribute' => __('business.fy_start_month')]),
            'accounting_method.required' => __('validation.required', ['attribute' => __('business.accounting_method')]),
        ];
    }
}


/**
 * $validator = $request->validate(
                [
                'name' => 'required|max:255',
                'currency_id' => 'required|numeric',
                'country' => 'required|max:255',
                'time_zone' => 'required|max:255',
                'email' => 'sometimes|nullable|email|unique:users|max:255',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'username' => 'required|min:4|max:255|unique:users',
                'password' => 'required|min:4|max:255'
                ],
                [
                'name.required' => __('validation.required', ['attribute' => __('business.business_name')]),
                'name.currency_id' => __('validation.required', ['attribute' => __('business.currency')]),
                'country.required' => __('validation.required', ['attribute' => __('business.country')]),
                'time_zone.required' => __('validation.required', ['attribute' => __('business.time_zone')]),
                'email.email' => __('validation.email', ['attribute' => __('business.email')]),
                'email.email' => __('validation.unique', ['attribute' => __('business.email')]),
                'first_name.required' => __('validation.required', ['attribute' =>
                    __('business.first_name')]),
                'username.required' => __('validation.required', ['attribute' => __('business.username')]),
                'username.min' => __('validation.min', ['attribute' => __('business.username')]),
                'password.required' => __('validation.required', ['attribute' => __('business.username')]),
                'password.min' => __('validation.min', ['attribute' => __('business.username')]),
                ]
            );
 */