<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ListRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ListRequest $request)
    {
        $filters = $request->only('customer_id', 'project_id', 'description', 'state', 'installation_type');

        $response = $this->projectService->list($filters);

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $response = $this->projectService->create($request);

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->projectService->show($id);

        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $response = $this->projectService->update($request, $id);

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->projectService->delete($id);

        return $response;
    }

    public function listEquipments(string $id)
    {
        $response = $this->projectService->listEquipments($id);

        return $response;
    }

    public function storeEquipment(StoreEquipmentRequest $request, string $id)
    {
        $response = $this->projectService->storeEquipment($request, $id);

        return $response;
    }

    public function updateEquipment(UpdateEquipmentRequest $request, string $id, string $equipmentId)
    {
        $response = $this->projectService->updateEquipment($request, $id, $equipmentId);

        return $response;
    }

    public function destroyEquipment(string $id, string $equipmentId)
    {
        $response = $this->projectService->destroyEquipment($id, $equipmentId);

        return $response;
    }

    public function listAllInstallationTypes()
    {
        $response = $this->projectService->listInstallationTypes();

        return $response;
    }

    public function listAllEquipments()
    {
        $response = $this->projectService->listAllEquipments();

        return $response;
    }
}
