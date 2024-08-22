<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EquipmentEnum;
use App\Models\Project;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'equipment_type',
        'quantity',
        'project_id'
    ];

    protected $casts = [
        'equipment_type' => EquipmentEnum::class
    ];

    public function projeto()
    {
        return $this->belongsTo(Project::class);
    }
}