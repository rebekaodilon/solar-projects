<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Services\CustomerService;

/**
 * @OA\Tag(
 *     name="Customers",
 *     description="API Endpoints of Customers"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     required={"name", "email", "phone", "document"},
 *     @OA\Property(property="name", type="string", example="Customer Test", description="Name of the customer"),
 *     @OA\Property(property="email", type="string", format="email", example="customer.john@example.com", description="Email of the customer"),
 *     @OA\Property(property="phone", type="string", example="(82) 3561-3037", description="Phone number of the customer"),
 *     @OA\Property(property="document", type="string", example="140.873.430-30", description="Document of the customer")
 * )
 */
class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function store(StoreRequest $request)
    {
        
        $response = $this->customerService->create($request);

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Display the specified customer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer details",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function show(string $id)
    {
        $response = $this->customerService->show($id);

        return $response;
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update the specified customer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function update(UpdateRequest $request, string $id)
    {
        $response = $this->customerService->update($request, $id);

        return $response;
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Remove the specified customer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Customer deleted successfully"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $response = $this->customerService->delete($id);

        return $response;
    }
}
