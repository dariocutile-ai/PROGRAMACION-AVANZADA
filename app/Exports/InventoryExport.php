<?php

namespace App\Exports;

use App\Services\Reports\ReportsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private ReportsService $reportsService) {}

    public function collection()
    {
        return $this->reportsService->inventorySummary();
    }

    public function headings(): array
    {
        return ['SKU', 'Producto', 'Categoría', 'Proveedor', 'Stock', 'Precio Compra', 'Precio Venta'];
    }

    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->category?->name,
            $product->supplier?->name,
            $product->stock,
            $product->purchase_price,
            $product->sale_price,
        ];
    }
}
