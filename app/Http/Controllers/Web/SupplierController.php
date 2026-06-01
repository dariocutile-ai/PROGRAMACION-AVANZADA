<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Suppliers\StoreSupplierRequest;
use App\Http\Requests\Suppliers\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\Suppliers\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(private readonly SupplierService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Supplier::class);

        $suppliers = Supplier::query()
            ->withCount('products')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%' . $request->string('q') . '%';
                $query->where('name', 'like', $search)->orWhere('email', 'like', $search);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        Gate::authorize('create', Supplier::class);

        return view('suppliers.create', ['supplier' => new Supplier()]);
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        Gate::authorize('create', Supplier::class);

        $supplier = $this->service->create($request->validated());

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Proveedor creado correctamente.');
    }

    public function show(Supplier $supplier): View
    {
        Gate::authorize('view', $supplier);

        $supplier->load(['products.category', 'comments.user']);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        Gate::authorize('update', $supplier);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        Gate::authorize('update', $supplier);

        $this->service->update($supplier->id, $request->validated());

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        Gate::authorize('delete', $supplier);

        $this->service->delete($supplier->id);

        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
