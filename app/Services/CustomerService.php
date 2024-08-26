<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    
    // list
    public function list(): JsonResponse
    {
        $customers = $this->customerRepository->list();
        return response()->json($customers, 200);
    }

    // create
    public function create($request): JsonResponse
    {
        try {
            $request = $request->all();

            if (isset($request['document'])) {
                $request['document'] = $this->clearDocument($request['document']);
            }
            if (isset($request['phone'])) {
                $request['phone'] = $this->clearPhone($request['phone']);
            }

            $customer = $this->customerRepository->create($request);

            if (!$customer) {
                return response()->json(['message' => 'Error creating customer'], 500);
            }

            return response()->json($customer, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // show
    public function show(string $id): JsonResponse
    {
        $customer = $this->customerRepository->show($id);
        return response()->json($customer, 200);
    }

    // update
    public function update($request, string $id): JsonResponse
    {
        try {

            $request = $request->all();
            
            if (isset($request['document'])) {
                $request['document'] = $this->clearDocument($request['document']);
            }
            if (isset($request['phone'])) {
                $request['phone'] = $this->clearPhone($request['phone']);
            }
            
            $customer = $this->customerRepository->update($id, $request);
            
            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }
            
            return response()->json(['message' => 'Customer updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // delete
    public function delete(string $id): JsonResponse
    {
        try {
            $customer = $this->customerRepository->delete($id);
            
            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }
            
            return response()->json(['message' => 'Customer deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Function to clear the document
    public function clearDocument(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }

    // Function to clear the phone
    public function clearPhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

}