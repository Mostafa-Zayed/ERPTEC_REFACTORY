<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        if(request()->isMethod('put') || request()->isMethod('patch')) {
            return self::UpdateRules();
        }
        
        return self::StoreRules();
    }
    
     protected static function StoreRules()
    {
        return [
            'name' => ['required'],
            'mobile' => ['required'],
            // 'contact_id' ['nullable']
        ];
    }
    
    protected static function UpdateRules()
    {
        return [
            
        ];
    }
}
