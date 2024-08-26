<?php

namespace App\Http\Requests\Customer;

use App\Base\BaseRequest;
use App\Traits\DocumentValidation;


class ListRequest extends BaseRequest
{    
    use DocumentValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
        ];
    }

    

}
