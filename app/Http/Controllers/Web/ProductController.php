<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\Products\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Product::class);

        $products = $this->service
            ->list($request->only(['q', 'category_id', 'supplier_id']), $request->only(['sort', 'order']))
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::query()->orderBy('name')->get(),
            'suppliers' => Supplier::query()->orderBy('name')->get(),
            'filters' => $request->only(['q', 'category_id', 'supplier_id', 'sort', 'order']),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Product::class);

        return view('products.create', $this->formData());
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        $product = $this->service->create($request->validated());

        return redirect()->route('products.show', $product)->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $product): View
    {
        Gate::authorize('view', $product);

        $product->load(['category', 'supplier', 'inventoryMovements.user', 'comments.user']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        Gate::authorize('update', $product);

        return view('products.edit', $this->formData($product));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        Gate::authorize('update', $product);

        $this->service->update($product->id, $request->validated());

        return redirect()->route('products.show', $product)->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);

        $this->service->delete($product->id);

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    private function formData(?Product $product = null): array
    {
        return [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
            'suppliers' => Supplier::query()->orderBy('name')->get(),
        ];
    }
}
