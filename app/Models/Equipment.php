<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EquipmentEnum;
use App\Models\Project;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'type',
        'quantity',
        'project_id'
    ];

    protected $casts = [
        'type' => EquipmentEnum::class
    ];

    public function projeto()
    {
        return $this->belongsTo(Project::class);
    }
}