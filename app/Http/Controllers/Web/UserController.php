<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);

        $users = User::query()
            ->with('roles')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%' . $request->string('q') . '%';
                $query->where('name', 'like', $search)->orWhere('email', 'like', $search);
            })
            ->when($request->filled('role_id'), fn ($query) => $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('roles.id', $request->integer('role_id'))))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', User::class);

        return view('users.create', [
            'user' => new User(),
            'roles' => Role::query()->orderBy('name')->get(),
            'selectedRoles' => [],
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = User::create(Arr::except($data, ['roles', 'password_confirmation']));
        $user->roles()->sync($data['roles']);

        return redirect()->route('users.show', $user)->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user): View
    {
        Gate::authorize('view', $user);

        $user->load(['roles']);

        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        return view('users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->orderBy('name')->get(),
            'selectedRoles' => $user->roles->pluck('id')->all(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $attributes = Arr::except($data, ['roles', 'password_confirmation']);

        if (blank($attributes['password'] ?? null)) {
            unset($attributes['password']);
        }

        $user->update($attributes);
        $user->roles()->sync($data['roles']);

        return redirect()->route('users.show', $user)->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
