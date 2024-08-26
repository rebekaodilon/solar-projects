<?php

namespace App\Http\Requests\Equipment;

use App\Base\BaseRequest;
use App\Enums\EquipmentEnum;


class UpdateEquipmentRequest extends BaseRequest
{    
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
            'type' => ['string', 'in:'.implode(',', array_column(EquipmentEnum::cases(), 'value'))],
            'quantity' => 'integer|min:1'
        ];
    }

    

}
