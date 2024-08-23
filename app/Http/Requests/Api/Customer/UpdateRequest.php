<?php

namespace App\Http\Requests\Api\Customer;

use App\Base\BaseRequest;
use App\Traits\DocumentValidation;

class UpdateRequest extends BaseRequest
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
            'name'      => 'string',
            'email'     => 'email',
            'phone'     => ['regex:/^(\+55\s?)?(\(?\d{2}\)?\s?)?(\d{4,5}[-\s]?\d{4})$/'],
            'document'  => [function ($attribute, $value, $fail) {
                if (!$this->validarCpfOuCnpj($value)) {
                    $fail('The document provided is not a valid CPF or CNPJ.');
                }
            }],
        ];
    }

    

}
