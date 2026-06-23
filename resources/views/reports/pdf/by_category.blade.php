<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventario por Categoría</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Reporte de Inventario por Categoría</h1>
    <p>Fecha de generación: {{ now()->format('Y-m-d H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Stock</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category?->name }}</td>
                    <td>{{ $product->supplier?->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>${{ number_format($product->stock * $product->purchase_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
