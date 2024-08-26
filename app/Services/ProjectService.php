<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProjectRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\CustomerRepository;
use App\Enums\EquipmentEnum;
use App\Enums\InstallationTypeEnum;
use App\Models\Equipment;

class ProjectService
{
    public function __construct(
        protected ProjectRepository $projectRepository, 
        protected EquipmentRepository $equipmentRepository,
        protected CustomerRepository $customerRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->equipmentRepository = $equipmentRepository;
        $this->customerRepository = $customerRepository;
    }

    // list
    public function list($request): JsonResponse
    {
        try{
            if (empty($request)) {
                $projects = $this->projectRepository->list()->toArray();
                $equipment = [];
                
                for ($i = 0; $i < count($projects); $i++) {
                    $projectEquipments = $this->equipmentRepository->listById($projects[$i]['id'])->toArray();
                    
                    $equipments = [];
                
                    for ($j = 0; $j < count($projectEquipments); $j++) {
                        
                        $equipments[] = [
                            'type' => $projectEquipments[$j]['type'],
                            'quantity' => $projectEquipments[$j]['quantity']
                        ];
                    }
                    $projects[$i]['equipments'] = $equipments;
                }
                return response()->json($projects, 200);


            } else {
                $filters = $request;

                $projects = $this->projectRepository->listWithFilters($filters)->toArray();

                if (empty($projects)) {
                    return response()->json(['message' => 'No projects found'], 404);
                }
                
                for ($i = 0; $i < count($projects); $i++) {
                    $projectEquipments = $this->equipmentRepository->listById($projects[$i]['id'])->toArray();
                    
                    $equipments = [];
                    
                    for ($j = 0; $j < count($projectEquipments); $j++) {
                        
                        $equipments[] = [
                            'type' => $projectEquipments[$j]['type'],
                            'quantity' => $projectEquipments[$j]['quantity']
                        ];
                    }
                    
                    $projects[$i]['equipments'] = $equipments;
                }

                return response()->json($projects, 200);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // create
    public function create($request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = $request->all();
            $equipments = $request['equipments'];

            unset($request['equipments']);

            $project = $this->projectRepository->create($request);

            if (!$project) {
                throw new \Exception('Error creating project');
            }

            foreach ($equipments as $equipment) {
                $equipment['project_id'] = $project->id;
                $savedEquipment = $this->equipmentRepository->create($equipment);

                if (!$savedEquipment) {
                    throw new \Exception('Error creating equipment');
                }
            }

            DB::commit();

            return response()->json($project, 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // show
    public function show(string $id): JsonResponse
    {
        try {
            $project = $this->projectRepository->show($id)->toArray();

            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }
            
            $customer = $this->customerRepository->show($project['customer_id'])->toArray();

            $project['customer'] = $customer;

            $projectEquipments = $this->equipmentRepository->listById($project['id'])->toArray();

            $equipments = [];

            for ($i = 0; $i < count($projectEquipments); $i++) {
                $equipments[] = [
                    'type' => $projectEquipments[$i]['type'],
                    'quantity' => $projectEquipments[$i]['quantity']
                ];
            }

            $project['equipments'] = $equipments;

            return response()->json($project, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // update
    public function update($request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = $request->all();

            $project = $this->projectRepository->update($id, $request);
            
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }
            
            DB::commit();

            return response()->json(['message' => 'Project updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // delete
    public function delete(string $id): JsonResponse
    {
        try {

            // delete the equipments related to the project
            $projectEquipments = $this->equipmentRepository->listById($id)->toArray();

            for ($i = 0; $i < count($projectEquipments); $i++) {
                $this->equipmentRepository->delete($projectEquipments[$i]['id']);
            }

            $project = $this->projectRepository->delete($id);
            
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }
            
            return response()->json(['message' => 'Project deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // listEquipments
    public function listEquipments(string $id): JsonResponse
    {
        try {
            $project = $this->projectRepository->show($id)->toArray();

            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }

            $projectEquipments = $this->equipmentRepository->listById($project['id'])->toArray();
            
            $equipments = [];

            for ($i = 0; $i < count($projectEquipments); $i++) {
                $equipments[] = [
                    'equipment_id' => $projectEquipments[$i]['id'],
                    'type' => $projectEquipments[$i]['type'],
                    'quantity' => $projectEquipments[$i]['quantity']
                ];
            }

            return response()->json($equipments, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // storeEquipment
    public function storeEquipment($request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = $request->all();
            $request['project_id'] = $id;

            $equipment = $this->equipmentRepository->create($request);

            if (!$equipment) {
                throw new \Exception('Error creating equipment');
            }

            DB::commit();

            return response()->json($equipment, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // updateEquipment
    public function updateEquipment($request, string $id, string $equipmentId): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = $request->all();

            $attributes = [
                'type' => $request['type'] ?? null,
                'quantity' => $request['quantity'] ?? null
            ];

            $attributes = array_filter($attributes, fn($value) => $value !== null);

            $equipment = $this->equipmentRepository->update($equipmentId, $attributes);

            if (!$equipment) {
                return response()->json(['message' => 'Equipment not found'], 404);
            }

            DB::commit();

            return response()->json(['message' => 'Equipment updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // destroyEquipment
    public function destroyEquipment(string $id, string $equipmentId): JsonResponse
    {
        try {
            $equipment = $this->equipmentRepository->delete($equipmentId);

            if (!$equipment) {
                return response()->json(['message' => 'Equipment not found'], 404);
            }

            return response()->json(['message' => 'Equipment deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // listAllEquipments
    public function listAllEquipments(): JsonResponse
    {
        try {
            $equipments = EquipmentEnum::cases();

            return response()->json($equipments, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // listInstallationTypes
    public function listInstallationTypes(): JsonResponse
    {
        try {
            $installationTypes = InstallationTypeEnum::cases();

            return response()->json($installationTypes, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}