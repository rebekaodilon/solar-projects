<?php

namespace App\Http\Requests\Project;

use App\Base\BaseRequest;
use App\Enums\InstallationTypeEnum;
use App\Enums\UFEnum;
use App\Enums\EquipmentEnum;


class ListRequest extends BaseRequest
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
            'customer_id'      => 'exists:customers,id',
            'description'      => 'string',
            'state' => ['string', 'in:' . implode(',', array_column(UFEnum::cases(), 'value'))],
            'installation_type' => ['string', 'in:' . implode(',', array_column(InstallationTypeEnum::cases(), 'value'))],
            'equipments' => 'array',
            'equipments.*.type' => ['string', 'in:' . implode(',', array_column(EquipmentEnum::cases(), 'value'))],
            'equipments.*.quantity' => 'integer|min:1'
        ];
    }

    

}
