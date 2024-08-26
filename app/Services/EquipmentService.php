<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Repositories\EquipmentRepository;

class EquipmentService
{
    public function __construct(
        protected EquipmentRepository $equipmentRepository
    )
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    // create
    public function create($request): JsonResponse
    {
        $request = $request->all();
        $equipment = $this->equipmentRepository->create($request);

        return response()->json($equipment, 201);
    }
}