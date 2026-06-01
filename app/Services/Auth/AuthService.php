<?php

namespace App\Services\Auth;

use App\Models\User;


class AuthService
{
    public function register(array $data): string
    {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return $this->issueToken($user);
    }

    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! password_verify($data['password'], $user->password)) {
            abort(401, 'Invalid credentials.');
        }

        return $this->issueToken($user);
    }

    public function logout(User $user): void

    {
        if (! $user) {
            return;
        }

        // Sanctum invalidates by deleting personal access tokens.
        // Use relationship method if available; otherwise fallback to direct query.
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

    }

    private function issueToken(User $user): string
    {
        return $user->createToken('inventorypro')->plainTextToken;
    }

}

