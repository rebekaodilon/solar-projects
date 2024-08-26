<?php

namespace App\Repositories;

use App\Base\BaseRepository;
use App\Models\Project;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;

class ProjectRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Project());
    }

    public function list()
    {
        return parent::findAll();
    }

    public function create($attributes): Project
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

    public function listWithFilters(array $filters)
    {   
        $data = Project::query();

        if (isset($filters['customer_id'])) {
            $data->orWhereIn('customer_id', (array)$filters['customer_id']);
        }

        if (isset($filters['project_id'])) {
            $data->orWhereIn('id', (array)$filters['project_id']);
        }

        if (isset($filters['description'])) {
            $data->orWhereIn('description', (array)$filters['description']);
        }

        if (isset($filters['state'])) {
            $data->orWhereIn('state', (array)$filters['state']);
        }

        if (isset($filters['installation_type'])) {
            $data->orWhereIn('installation_type', (array)$filters['installation_type']);
        }

        return $data->get();
    }
}
