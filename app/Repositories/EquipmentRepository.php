<?php

namespace App\Repositories;

use App\Base\BaseRepository;
use App\Models\Equipment;

class EquipmentRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Equipment());
    }

    public function list()
    {
        return parent::findAll();
    }

    public function listById($projectId)
    {
        return parent::findAllByField('project_id', $projectId);
    }

    public function findAllByField($field, $value): Equipment
    {
        return parent::findAllByField($field, $value);
    }

    public function create($attributes): Equipment
    {
        return parent::create($attributes);
    }

    public function show($id)
    {
        return parent::find($id);
    }

    public function update($id, $attributes)
    {
        return parent::update($id, $attributes);
    }

    public function delete($id)
    {
        return parent::destroy($id);
    }
}
