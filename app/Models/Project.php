<?php

namespace App\Models;

use App\Enums\EquipmentEnum;
use App\Enums\InstallationTypeEnum;
use App\Enums\UFEnum;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'description',
        'state',
        'installation_type',
        'equipments',
        'customer_id'
    ];

    protected $casts = [
        'equipments' => EquipmentEnum::class,
        'state' => UFEnum::class,
        'installation_type' => InstallationTypeEnum::class
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}