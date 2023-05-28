<?php

namespace App\Http\Requests\Warranties;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Traits\ValidationResponse;

class StoreWarranty extends FormRequest
{
    use ValidationResponse;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return (request()->isMethod('post') || request()->isMethod('patch')) ? $this->updateRules() : $this->storeRules();
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
            'name' => ['required','max:255'],
            'description' => ['nullable'],
            'document' => ['nullable'],
            'duration' => ['required','max:255'],
            'duration_type' => ['required','in:days,months,years']
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
            'name' => ['required','max:255'],
            'description' => ['nullable'],
            'document' => ['nullable'],
            'duration' => ['required','max:255'],
            'duration_type' => ['required','in:days,months,years']
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationToJson($validator->errors()->all()));
    }
}