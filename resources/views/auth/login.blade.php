@extends('layouts.app')

@section('title', 'Acceso | InventoryPro')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 82vh;">
    <div class="col-md-6 col-xl-4">
        <div class="text-center mb-4">
            <div class="brand-mark mx-auto mb-3"><i class="bi bi-box-seam"></i></div>
            <h1 class="h3 mb-1">InventoryPro</h1>
            <p class="text-muted-strong mb-0">Gestion de inventario conectada a datos reales.</p>
        </div>
        <div class="panel p-4">
            <form method="post" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right me-1"></i>Entrar</button>
            </form>
        </div>
        <div class="small text-muted-strong mt-3">
            Demo: test@example.com, manager@example.com o employee@example.com / password
        </div>
    </div>
</div>
@endsection
