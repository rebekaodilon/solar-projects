<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnumRule implements Rule
{
    protected $enumClass;

    public function __construct($enumClass)
    {
        $this->enumClass = $enumClass;
    }

    public function passes($attribute, $value)
    {
        $enumValues = array_column($this->enumClass::cases(), 'value');
        return in_array($value, $enumValues);
    }

    public function message()
    {
        return 'The selected value is not valid.';
    }
}
