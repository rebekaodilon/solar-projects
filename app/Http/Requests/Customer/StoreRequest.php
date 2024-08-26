<?php

namespace App\Http\Requests\Customer;

use App\Base\BaseRequest;
use App\Traits\DocumentValidation;

class StoreRequest extends BaseRequest
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
            'name'      => 'required|string',
            'email'     => 'required|email',
            'phone'     => ['required', 'regex:/^(\+55\s?)?(\(?\d{2}\)?\s?)?(\d{4,5}[-\s]?\d{4})$/'],
            'document'  => ['required', function ($attribute, $value, $fail) {
                if (!$this->validarCpfOuCnpj($value)) {
                    $fail('The document provided is not a valid CPF or CNPJ.');
                }
            }],
        ];
    }

    

}
