<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Inventory\StoreInventoryMovementRequest;
use App\Http\Resources\Inventory\InventoryMovementResource;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\JsonResponse;

class InventoryMovementsController extends BaseApiController
{
    public function __construct(private readonly InventoryService $service)
    {
    }

    // middleware se aplica en routes/api.php

    public function store(StoreInventoryMovementRequest $request): JsonResponse

    {
        $movement = $this->service->createMovement($request->validated());

        return response()->json([
            'data' => new InventoryMovementResource($movement->load(['product', 'user'])),
        ], 201);
    }
}


