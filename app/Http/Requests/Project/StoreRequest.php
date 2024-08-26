<?php

namespace App\Http\Requests\Project;

use App\Base\BaseRequest;
use App\Enums\InstallationTypeEnum;
use App\Enums\UFEnum;
use App\Enums\EquipmentEnum;


class StoreRequest extends BaseRequest
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
            'customer_id'      => 'required|exists:customers,id',
            'description'      => 'required|string',
            'state' => ['required', 'string', 'in:' . implode(',', array_column(UFEnum::cases(), 'value'))], //O estado onde o cliente planeja instalar a usina.
            'installation_type' => ['required', 'string', 'in:' . implode(',', array_column(InstallationTypeEnum::cases(), 'value'))], //O tipo de instalação, que se refere ao tipo de telhado no local onde o cliente planeja instalar a usina.
            'equipments' => 'required|array', //Os equipamentos que serão utilizados na instalação
            'equipments.*.type' => ['required', 'string', 'in:' . implode(',', array_column(EquipmentEnum::cases(), 'value'))],
            'equipments.*.quantity' => 'required|integer|min:1'
        ];
    }

    

}
