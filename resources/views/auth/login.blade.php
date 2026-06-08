@extends('layouts.app')

@section('title', 'Acceso | InventoryPro')

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="text-center">
                <div class="login-brand-icon"><i class="bi bi-box-seam"></i></div>
                <h1 class="login-title">InventoryPro</h1>
                <p class="login-subtitle">Gestión de inventario conectada a datos reales</p>
            </div>
            
            <form method="post" action="{{ route('login.store') }}" class="login-form">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required placeholder="••••••••">
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </button>
            </form>
            
            <div class="login-footer">
                PROGRAMACIÓN AVANZADA - 2026 - P1
            </div>
        </div>
    </div>
</div>
@endsection
