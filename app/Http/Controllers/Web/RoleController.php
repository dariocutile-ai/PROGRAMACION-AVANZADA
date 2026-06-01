<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Role::class);

        $roles = Role::query()
            ->withCount('users')
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%' . $request->string('q') . '%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        Gate::authorize('create', Role::class);

        return view('roles.create', ['role' => new Role()]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        return redirect()->route('roles.show', $role)->with('success', 'Rol creado correctamente.');
    }

    public function show(Role $role): View
    {
        Gate::authorize('view', $role);

        $role->load('users');

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        Gate::authorize('update', $role);

        return view('roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()->route('roles.show', $role)->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        Gate::authorize('delete', $role);

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
