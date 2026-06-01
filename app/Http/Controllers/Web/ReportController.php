<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use App\Services\Reports\ReportsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportsService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Report::class);

        return view('reports.index', [
            'lowStock' => $this->service->lowStock(),
            'mostSold' => $this->service->mostSold(10),
            'recentMovements' => $this->service->recentMovements(20),
            'inventorySummary' => $this->service->inventorySummary(),
            'byCategory' => $this->service->byCategory($request->input('category_id')),
            'categories' => Category::query()->orderBy('name')->get(),
            'selectedCategory' => $request->input('category_id'),
        ]);
    }
}
