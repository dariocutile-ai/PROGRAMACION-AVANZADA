<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Reports\LowStockReportResourceCollection;
use App\Http\Resources\Reports\InventorySummaryReportResourceCollection;
use App\Http\Resources\Reports\RecentMovementsReportResourceCollection;
use App\Http\Resources\Reports\MostSoldReportResourceCollection;
use App\Http\Resources\Reports\CategoryStockReportResourceCollection;
use App\Services\Reports\ReportsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportsController extends BaseApiController
{
    public function __construct(private readonly ReportsService $service)
    {
    }

    public function lowStock(): LowStockReportResourceCollection
    {
        return new LowStockReportResourceCollection(
            $this->service->lowStock()
        );
    }

    public function mostSold(): MostSoldReportResourceCollection
    {
        return new MostSoldReportResourceCollection(
            $this->service->mostSold()
        );
    }

    public function recentMovements(Request $request): RecentMovementsReportResourceCollection
    {
        $limit = (int) $request->query('limit', 20);
        $limit = max(1, min(100, $limit));

        return new RecentMovementsReportResourceCollection(
            $this->service->recentMovements($limit)
        );
    }

    public function inventorySummary(): InventorySummaryReportResourceCollection
    {
        return new InventorySummaryReportResourceCollection(
            $this->service->inventorySummary()
        );
    }

    public function byCategory(Request $request): CategoryStockReportResourceCollection
    {
        $categoryId = $request->query('category_id');

        return new CategoryStockReportResourceCollection(
            $this->service->byCategory($categoryId)
        );
    }
}

