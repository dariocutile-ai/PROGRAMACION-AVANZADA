<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Suppliers\StoreSupplierRequest;
use App\Http\Requests\Suppliers\UpdateSupplierRequest;
use App\Http\Resources\Suppliers\SupplierResource;
use App\Http\Resources\Suppliers\SupplierResourceCollection;
use App\Services\Suppliers\SupplierService;
use Illuminate\Http\JsonResponse;

class SuppliersController extends BaseApiController
{
    public function __construct(private readonly SupplierService $service)
    {
    }

    public function index(): SupplierResourceCollection
    {
        return new SupplierResourceCollection($this->service->index());
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->service->create($request->validated());

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 201);
    }

    public function show(int $supplier): SupplierResource
    {
        return new SupplierResource($this->service->show($supplier));
    }

    public function update(UpdateSupplierRequest $request, int $supplier): JsonResponse
    {
        $model = $this->service->update($supplier, $request->validated());

        return response()->json([
            'data' => new SupplierResource($model),
        ]);
    }

    public function destroy(int $supplier): JsonResponse
    {
        $this->service->delete($supplier);

        return response()->json([], 204);
    }
}

