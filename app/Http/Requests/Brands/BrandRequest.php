<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Traits\ValidationResponse;

class BrandRequest extends FormRequest
{
    // use ValidationResponse;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return (request()->isMethod('put') || request()->isMethod('patch')) ? $this->updateRules() : $this->storeRules();
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the Store request.
     *
     * @return array
     */
    public function storeRules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
    
    /**
     * Get the validation rules that apply to the Update request.
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'meta_title' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'meta_description' => ['nullable'],
            'logo' => ['nullable'],
            'use_for_repair' => ['nullable']
        ];
    }
    
    public function response(array $errors)
    {
        return request()->ajax() || $this->wantsJson() ? 
            response([
                'status' => false,
                'statusCode' => 422,
                'statusType' => 'Unprocessable',
                'errors' => $errors
            ],422) : back()->withErrors($errors)->withInput();
    }
    
    // protected function failedValidation(Validator $validator)
    // {
        
    //     throw new HttpResponseException($this->validationToJson($validator->errors()));
    // }
}