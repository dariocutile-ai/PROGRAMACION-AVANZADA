<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Bajo</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #d9534f; }
    </style>
</head>
<body>
    <h1>Reporte de Productos con Stock Bajo</h1>
    <p>Fecha de generación: {{ now()->format('Y-m-d H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Stock Actual</th>
                <th>Nivel Mínimo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category?->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->reorder_level }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
