@extends('layouts.app')

@section('title', 'Auditoría | InventoryPro')
@section('page_title', 'Logs de Seguridad')
@section('page_subtitle', 'Bitácora de eventos y acciones del sistema')

@section('content')
<div class="github-panel p-4">
    <div class="table-responsive">
        <table class="table table-hover data-table w-100">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Módulo</th>
                    <th>IP</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $log->user ? $log->user->name : 'Sistema/Anon' }}</td>
                        <td>
                            @if ($log->action === 'login' || $log->action === 'logout')
                                <span class="badge bg-info">{{ $log->action }}</span>
                            @elseif ($log->action === 'failed_login')
                                <span class="badge bg-danger">{{ $log->action }}</span>
                            @elseif ($log->action === 'deleted')
                                <span class="badge bg-danger">{{ $log->action }}</span>
                            @elseif ($log->action === 'created')
                                <span class="badge bg-success">{{ $log->action }}</span>
                            @elseif ($log->action === 'updated')
                                <span class="badge bg-warning text-dark">{{ $log->action }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $log->action }}</span>
                            @endif
                        </td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>
                            @if ($log->details)
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                    Ver JSON
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark">Detalles del Log #{{ $log->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <pre class="bg-dark text-light p-3 rounded"><code>{{ json_encode($log->details, JSON_PRETTY_PRINT) }}</code></pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
