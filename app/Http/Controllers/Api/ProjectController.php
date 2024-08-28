<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ListRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Services\ProjectService;
/**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     required={"name", "description", "status"},
 *     @OA\Property(property="description", type="string", description="Description of the project", example="Projeto de teste"),
 *     @OA\Property(property="state", type="string", description="location of the project", example="SP"),
 *     @OA\Property(property="installation_type", type="string", description="Type of installation", example="Fibrocimento (Madeira)"),
 *     @OA\Property(property="customer_id", type="integer", description="ID of the customer", example=1),
 *     @OA\Property(property="equipments", type="array", description="List of equipments for the project", @OA\Items(ref="#/components/schemas/Equipment", example={"type": "Módulo", "quantity": 10})),
 * )
 */
class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="List all projects",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of projects",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     )
     * )
     */
    public function index(ListRequest $request)
    {
        $filters = $request->only('customer_id', 'project_id', 'description', 'state', 'installation_type');

        $response = $this->projectService->list($filters);

        return $response;
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
     */
    public function store(StoreRequest $request)
    {
        $response = $this->projectService->create($request);

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a specific project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $response = $this->projectService->show($id);

        return $response;
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a specific project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function update(UpdateRequest $request, string $id)
    {
        $response = $this->projectService->update($request, $id);

        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a specific project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Project deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $response = $this->projectService->delete($id);

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}/equipments",
     *     summary="List all equipments for a specific project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of equipments for the specified project",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Equipment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Error message")
     *         )
     *     )
     * )
     */
    public function listEquipments(string $id)
    {
        $response = $this->projectService->listEquipments($id);

        return $response;
    }

    /**
     * @OA\Post(
     *     path="/api/projects/{id}/equipments",
     *     summary="Store a new equipment for a specific project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreEquipmentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Equipment stored successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Equipment")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Validation error message"),
     *             @OA\Property(property="errors", type="object", description="Validation errors")
     *         )
     *     )
     * )
     */
    public function storeEquipment(StoreEquipmentRequest $request, string $id)
    {
        $response = $this->projectService->storeEquipment($request, $id);

        return $response;
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}/equipments/{equipmentId}",
     *     summary="Update a specific equipment for a project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="equipmentId",
     *         in="path",
     *         description="ID of the equipment to be updated",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Equipment")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Validation error message"),
     *             @OA\Property(property="errors", type="object", description="Validation errors")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Error message")
     *         )
     *     )
     * )
     */
    public function updateEquipment(UpdateEquipmentRequest $request, string $id, string $equipmentId)
    {
        $response = $this->projectService->updateEquipment($request, $id, $equipmentId);

        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}/equipments/{equipmentId}",
     *     summary="Delete a specific equipment for a project",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="equipmentId",
     *         in="path",
     *         description="ID of the equipment to be deleted",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Deletion confirmation message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", description="Request status"),
     *             @OA\Property(property="message", type="string", description="Error message")
     *         )
     *     )
     * )
     */
    public function destroyEquipment(string $id, string $equipmentId)
    {
        $response = $this->projectService->destroyEquipment($id, $equipmentId);

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/installation-types",
     *     summary="List all installation types",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of installation types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/InstallationType")
     *         )
     *     )
     * )
     */
    public function listAllInstallationTypes()
    {
        $response = $this->projectService->listInstallationTypes();

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/equipments",
     *     summary="List all equipments",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all equipments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Equipment")
     *         )
     *     )
     * )
     */
    public function listAllEquipments()
    {
        $response = $this->projectService->listAllEquipments();

        return $response;
    }
}
