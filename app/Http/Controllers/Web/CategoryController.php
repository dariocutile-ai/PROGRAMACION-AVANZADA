<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Categories\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Category::class);

        $categories = Category::query()
            ->withCount('products')
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%' . $request->string('q') . '%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        Gate::authorize('create', Category::class);

        return view('categories.create', ['category' => new Category()]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);

        $category = $this->service->create($request->validated());

        return redirect()->route('categories.show', $category)->with('success', 'Categoria creada correctamente.');
    }

    public function show(Category $category): View
    {
        Gate::authorize('view', $category);

        $category->load(['products.supplier', 'comments.user']);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        Gate::authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $this->service->update($category->id, $request->validated());

        return redirect()->route('categories.show', $category)->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        $this->service->delete($category->id);

        return redirect()->route('categories.index')->with('success', 'Categoria eliminada correctamente.');
    }
}
