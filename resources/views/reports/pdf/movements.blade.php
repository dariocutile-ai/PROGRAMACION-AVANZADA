<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movimientos Recientes</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Reporte de Movimientos Recientes</h1>
    <p>Fecha de generación: {{ now()->format('Y-m-d H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $movement)
                <tr>
                    <td>{{ $movement->created_at?->format('Y-m-d H:i') }}</td>
                    <td>{{ $movement->product?->name }}</td>
                    <td>{{ ['purchase'=>'Compra','restock'=>'Reabastecimiento','sale'=>'Venta','waste'=>'Merma'][$movement->type] ?? ucfirst($movement->type) }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->user?->name ?? 'Sistema' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
