<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Categories\CategoryResourceCollection;
use App\Services\Categories\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoriesController extends BaseApiController
{
    public function __construct(private readonly CategoryService $service)
    {
    }

    public function index(): CategoryResourceCollection
    {
        return new CategoryResourceCollection($this->service->index());
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->create($request->validated());

        return response()->json([
            'data' => new CategoryResource($category->load(['products'])),
        ], 201);
    }

    public function show(int $category): CategoryResource
    {
        return new CategoryResource($this->service->show($category));
    }

    public function update(UpdateCategoryRequest $request, int $category): JsonResponse
    {
        $categoryModel = $this->service->update($category, $request->validated());

        return response()->json([
            'data' => new CategoryResource($categoryModel->load(['products'])),
        ]);
    }

    public function destroy(int $category): JsonResponse
    {
        $this->service->delete($category);

        return response()->json([], 204);
    }
}

