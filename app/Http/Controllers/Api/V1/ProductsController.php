<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductResourceCollection;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends BaseApiController
{
    public function __construct(private readonly ProductService $service) {}

    public function index(Request $request): ProductResourceCollection
    {
        $filters = $request->only(['q', 'category_id', 'supplier_id']);
        $sort = $request->only(['sort', 'order']);

        return new ProductResourceCollection(
            $this->service->list($filters, $sort)
        );
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());

        return response()->json([
            'data' => new ProductResource($product),
        ], 201);
    }

    public function show(int $id): ProductResource
    {
        $product = $this->service->getById($id);

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->service->update($id, $request->validated());

        return response()->json([
            'data' => new ProductResource($product),
        ], 200);
    }

    public function destroy(int $id): Response
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}

