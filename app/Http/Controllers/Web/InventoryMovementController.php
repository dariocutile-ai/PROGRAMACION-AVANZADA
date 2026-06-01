<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreInventoryMovementRequest;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class InventoryMovementController extends Controller
{
    public function __construct(private readonly InventoryService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', InventoryMovement::class);

        $movements = InventoryMovement::query()
            ->with(['product.category', 'user'])
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->when($request->filled('product_id'), fn ($query) => $query->where('product_id', $request->integer('product_id')))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%' . $request->string('q') . '%';
                $query->whereHas('product', fn ($productQuery) => $productQuery->where('name', 'like', $search)->orWhere('sku', 'like', $search));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('inventory.index', [
            'movements' => $movements,
            'products' => Product::query()->orderBy('name')->get(),
            'types' => ['purchase', 'restock', 'sale', 'waste'],
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', InventoryMovement::class);

        return view('inventory.create', [
            'products' => Product::query()->with(['category'])->orderBy('name')->get(),
            'types' => ['purchase', 'restock', 'sale', 'waste'],
        ]);
    }

    public function store(StoreInventoryMovementRequest $request): RedirectResponse
    {
        Gate::authorize('create', InventoryMovement::class);

        $movement = $this->service->createMovement($request->validated());

        return redirect()->route('inventory.movements.show', $movement)->with('success', 'Movimiento registrado y stock actualizado.');
    }

    public function show(InventoryMovement $movement): View
    {
        Gate::authorize('view', $movement);

        $movement->load(['product.category', 'product.supplier', 'user']);

        return view('inventory.show', compact('movement'));
    }
}
